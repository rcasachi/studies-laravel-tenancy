<?php

namespace App\Console\Commands;

use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {subdomain} {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Tenant with a subdomain, name and email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url_base = config('app.url_base');
        $subdomain = $this->argument('subdomain');
        $name = $this->argument('name');
        $email = $this->argument('email');
        $full_domain = "{$subdomain}.{$url_base}";

        // tenant exists?
        if ( $this->tenantExists( $full_domain ) ) {
            $this->error( "A tenant with the subdomain '{$subdomain}' already exists." );
            return;
        }

        // if the tenant doesn't exist, we'll use the Tenancy package commands to create one
        $hostname = $this->createTenant( $full_domain );

        // swap the environment over to the hostname
        app( Environment::class )->hostname( $hostname );


        // create a new user
        $password = str_random();
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make( $password )
        ]);

        $this->info( "Tenant '{$name}' created for {$full_domain}");
        $this->info( "The user '{$email}' can log in with password {$password}");
    }

    private function tenantExists( $full_domain ) {
        return Hostname::where( 'fqdn', $full_domain )->exists();
    }

    private function createTenant( $full_domain )
    {
        $website = new Website;
        app( WebsiteRepository::class )->create( $website );

        $hostname = new Hostname;
        $hostname->fqdn = $full_domain;
        app( HostnameRepository::class )->attach( $hostname, $website );

        return $hostname;
    }
}

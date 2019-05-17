<?php

namespace App\Console\Commands\PHP;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

class Sniff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:php:sniff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sniffs PHP code style using PHP Code Sniffer and Laravel coding standard.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $output  = new ConsoleOutput();
        $root    = dirname( __DIR__, 4 );
        $arr     = [
            'vendor/bin/phpcs',
            '--standard=vendor/pragmarx/laravelcs/Standards/Laravel',
            $root . '/app',
        ];
        $process = new Process( $arr );
        $process->setWorkingDirectory( $root );
        $process->run( function ( $type, $buffer ) use ( $output ) {
            if ( $type === Process::ERR ) {
                $output->writeln( 'Error: ' . $buffer );
                return;
            }
            $output->writeln( $buffer );
        } );
    }
}

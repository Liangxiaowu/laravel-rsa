<?php


namespace LaraRsa\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RsaKeyCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'lararsa:config';
//        {--s|show : Display the key instead of modifying files.}
//        {--always-no : Skip generating key if it already exists.}
//        {--f|force : Skip confirmation when overwriting an existing key.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the lararsa config';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->configPath();

        $source = realpath(__DIR__.'/../config/config.php');

        if(!copy($source, $path)){
            $this->error('lararsa File creation failed');
        };
        $this->info('Create success：'.$path);
//        $this->line('Create success：'.$path);


    }



    /**
     * Get the conifg file path.
     *
     * @return string
     */
    protected function configPath()
    {
        return $this->laravel->basePath().DIRECTORY_SEPARATOR.'config/lararsa.php';
    }
}

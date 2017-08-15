<?php

namespace Instapp\Command;

use InstagramAPI\Instagram;
use Instapp\Instapp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Instapp\Command\Traits\Data;

class InstagramCommand extends Command
{
    use Data\Login;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Instapp
     */
    protected $instapp;

    /**
     * InstagramCommand constructor.
     * @param Instapp $instapp
     * @param string $name
     */
    public function __construct($instapp, $name = null)
    {
        $this->instapp = $instapp;
        parent::__construct($name);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this
            ->addOption('username', 'u', InputArgument::OPTIONAL, 'Account username')
            ->addOption('password', 'p', InputArgument::OPTIONAL, 'Account password')
            ->addOption('wait', null, InputArgument::OPTIONAL, 'Wait time')
        ;

        $this->instapp['logger']->title("Instagram Api Bot: {$this->getDescription()}");

        $this->login();
    }

    protected function login($useOption = true)
    {
        $loginData = $this->getLoginData($useOption);

        try {
            $this->instapp->login($loginData['username'], $loginData['password']);
        } catch (\Exception $e) {
            $this->instapp['logger']->error($e->getMessage());
            return $this->login(false);
        }
    }
}
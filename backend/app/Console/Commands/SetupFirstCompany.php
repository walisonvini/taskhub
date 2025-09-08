<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SetupFirstCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:first-company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criação interativa da primeira empresa e primeiro usuário';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Bem-vindo ao TaskHub!');
        $this->line('Vamos configurar sua primeira empresa e usuário.');
        $this->line('');

        if (Company::count() > 0) {
            $this->warn('Já existem empresas cadastradas.');
            if (!$this->confirm('Continuar mesmo assim?')) {
                return 0;
            }
        }

        $this->line('Primeiro, vamos cadastrar sua empresa:');
        $companyData = $this->collectCompanyData();
        $company = Company::create($companyData);
        $this->info("Empresa '{$company->name}' criada!");
        $this->line('');

        $this->line('Agora vamos criar seu usuário:');
        $userData = $this->collectUserData($company->id);
        $user = User::create($userData);
        $this->info("Usuário '{$user->name}' criado!");
        $this->line('');

        $this->info('Pronto! Configuração concluída.');
        $this->line('');
        $this->line("Empresa: {$company->name}");
        $this->line("Usuário: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line('');

        return 0;
    }

    /**
     * Coletar dados da empresa
     */
    private function collectCompanyData()
    {
        $name = $this->ask('Qual o nome da sua empresa?');
        while (empty($name)) {
            $this->error('Nome é obrigatório');
            $name = $this->ask('Qual o nome da sua empresa?');
        }

        $alias = $this->ask('Alias (identificador único)', strtolower(str_replace(' ', '', $name)));
        while (empty($alias)) {
            $this->error('Alias é obrigatório');
            $alias = $this->ask('Alias (identificador único)');
        }

        $cnpj = $this->ask('CNPJ (14 números)');
        
        $validator = Validator::make(['cnpj' => $cnpj], [
            'cnpj' => 'required|string|size:14|unique:companies,cnpj'
        ]);

        while ($validator->fails()) {
            $this->error('CNPJ inválido ou já existe');
            $cnpj = $this->ask('CNPJ (14 números)');
            $validator = Validator::make(['cnpj' => $cnpj], [
                'cnpj' => 'required|string|size:14|unique:companies,cnpj'
            ]);
        }

        return [
            'name' => $name,
            'alias' => $alias,
            'cnpj' => $cnpj,
        ];
    }

    /**
     * Coletar dados do usuário
     */
    private function collectUserData($companyId)
    {
        $name = $this->ask('Seu nome completo');
        while (empty($name)) {
            $this->error('Nome é obrigatório');
            $name = $this->ask('Seu nome completo');
        }

        $email = $this->ask('Seu email');
        
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email'
        ]);

        while ($validator->fails()) {
            $this->error('Email inválido ou já existe');
            $email = $this->ask('Seu email');
            $validator = Validator::make(['email' => $email], [
                'email' => 'required|email|unique:users,email'
            ]);
        }

        $password = $this->secret('Sua senha');
        while (strlen($password) < 6) {
            $this->error('Senha deve ter pelo menos 6 caracteres');
            $password = $this->secret('Sua senha');
        }

        $confirmPassword = $this->secret('Confirmar senha');
        while ($password !== $confirmPassword) {
            $this->error('Senhas não coincidem');
            $password = $this->secret('Sua senha');
            $confirmPassword = $this->secret('Confirmar senha');
        }

        return [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'company_id' => $companyId,
            'email_verified_at' => now(),
        ];
    }
}
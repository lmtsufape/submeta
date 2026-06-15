<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;

class CpfFix extends Command
{
    protected $signature = 'fix:cpf';
    protected $description = 'Apply CPF mask to records missing it';

    public function handle()
    {
        $users = User::whereRaw('LENGTH(cpf) < 14')->get(['id', 'cpf']);

        if ($users->isEmpty()) {
            $this->info('No records to fix.');
            return;
        }

        $results = $users->map(function ($u) {
            $digits = preg_replace('/\D/', '', $u->cpf);
            $masked = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
            return ['id' => $u->id, 'old' => $u->cpf, 'new' => $masked];
        });

        $this->table(['ID', 'Old CPF', 'New CPF'], $results->map(function ($r) {
            return [ $r['id'], $r['old'], $r['new']];
        }));

        if (!$this->confirm("Commit {$results->count()} changes?")) {
            $this->warn('Aborted.');
            return;
        }

        DB::transaction(function () use ($results) {
            foreach ($results as $r) {
                User::where('id', $r['id'])->update(['cpf' => $r['new']]);
            }
        });

        $this->info("Done. {$results->count()} records updated.");
    }
}
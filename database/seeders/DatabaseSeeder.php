<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ===== BASE =====
        $this->call(UsuarioSeeder::class);

        // ===== PAPÉIS ===== - passou
        $this->call(AdministradorSeeder::class);
        $this->call(AdministradorResponsavelSeeder::class);
        $this->call(ProponenteSeeder::class);

        // ===== ESTRUTURA ACADÊMICA ===== - todo: rever
        $this->call(GrandeAreaSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(SubAreaSeeder::class);
        $this->call(CursoSeeder::class);
        $this->call(AreaTematicaSeeder::class);

        //continua users devido a dependencias
        $this->call(CoordenadorComissaoSeeder::class);
        $this->call(AvaliadorSeeder::class);


        // ===== CONFIG AUXILIAR ===== - todo: rever
        $this->call(FuncaoParticipanteSeeder::class);
        $this->call(NaturezaSeeder::class);
        $this->call(RecomendacaoSeeder::class);

        // ===== NÚCLEO DO SISTEMA =====todo: testar
        $this->call(EventoSeeder::class);
        $this->call(TrabalhoSeeder::class);

        $this->call(ParticipanteSeeder::class);


        // ===== DEPENDÊNCIAS DE TRABALHO ===== todo:  rever
        $this->call(ArquivoSeeder::class);
        $this->call(CampoAvaliacaoSeeder::class);

        // ===== RELACIONAMENTOS ===== todo: rever y testar
        $this->call(AvaliadorEventoSeeder::class);      // avaliador ↔ evento
        $this->call(AvaliadorTrabalhoSeeder::class);    // avaliador ↔ trabalho

        // ===== AVALIAÇÕES ===== todo: rever y testar
        $this->call(AvaliacaoTrabalhosSeeder::class);
        $this->call(AvaliacaoRelatorioSeeder::class);

        DB::statement("
            DO $$
            DECLARE
                rec RECORD;
            BEGIN
                FOR rec IN
                    SELECT sequence_name
                    FROM information_schema.sequences
                    WHERE sequence_schema = 'public'
                LOOP
                    EXECUTE format(
                        'SELECT setval(%L, COALESCE((SELECT MAX(id) FROM %I), 1))',
                        rec.sequence_name,
                        replace(rec.sequence_name, '_id_seq', '')
                    );
                END LOOP;
            END $$;
        ");

    }
}

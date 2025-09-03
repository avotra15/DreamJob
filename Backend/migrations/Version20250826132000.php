<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250826132000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables et séquences initiales, idempotente';
    }

    public function up(Schema $schema): void
    {
        // Tables principales avec SERIAL pour auto-incrément
        $this->addSql('CREATE TABLE IF NOT EXISTS country (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            code VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE TABLE IF NOT EXISTS roles (
            id SERIAL PRIMARY KEY,
            roles VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            role_id INT NOT NULL,
            nom VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_1483A5E9D60322AC ON users (role_id)');

        $this->addSql('CREATE TABLE IF NOT EXISTS cv (
            id SERIAL PRIMARY KEY,
            email_cand_id INT DEFAULT NULL,
            namecv VARCHAR(255) NOT NULL
        )');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_B66FFE92521C886C ON cv (email_cand_id)');

        $this->addSql('CREATE TABLE IF NOT EXISTS job_details (
            id SERIAL PRIMARY KEY,
            email_id INT DEFAULT NULL,
            fichier VARCHAR(255) NOT NULL,
            titre VARCHAR(255) NOT NULL,
            description VARCHAR(500) NOT NULL,
            logo VARCHAR(255) NOT NULL
        )');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_E8C9BC11A832C1C9 ON job_details (email_id)');

        $this->addSql('CREATE TABLE IF NOT EXISTS time (
            id SERIAL PRIMARY KEY,
            duration VARCHAR(255) NOT NULL
        )');

        // Table messenger_messages
        $this->addSql('CREATE TABLE IF NOT EXISTS messenger_messages (
            id BIGSERIAL PRIMARY KEY,
            body TEXT NOT NULL,
            headers TEXT NOT NULL,
            queue_name VARCHAR(190) NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL
        )');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');

        // Trigger Messenger
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS messenger_messages CASCADE');
        $this->addSql('DROP TABLE IF EXISTS job_details CASCADE');
        $this->addSql('DROP TABLE IF EXISTS cv CASCADE');
        $this->addSql('DROP TABLE IF EXISTS users CASCADE');
        $this->addSql('DROP TABLE IF EXISTS roles CASCADE');
        $this->addSql('DROP TABLE IF EXISTS country CASCADE');
        $this->addSql('DROP TABLE IF EXISTS time CASCADE');
    }
}

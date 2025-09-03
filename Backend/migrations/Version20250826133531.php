<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250826133531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables et séquences initiales de manière idempotente';
    }

    public function up(Schema $schema): void
    {
        // Séquences avec DROP IF EXISTS pour éviter le duplicate
        $this->addSql('DROP SEQUENCE IF EXISTS country_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('DROP SEQUENCE IF EXISTS cv_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE cv_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('DROP SEQUENCE IF EXISTS job_details_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE job_details_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('DROP SEQUENCE IF EXISTS roles_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('DROP SEQUENCE IF EXISTS time_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE time_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('DROP SEQUENCE IF EXISTS users_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        // Tables avec CREATE TABLE IF NOT EXISTS
        $this->addSql('CREATE TABLE IF NOT EXISTS country (
            id INT NOT NULL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            code VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE TABLE IF NOT EXISTS roles (
            id INT NOT NULL PRIMARY KEY,
            roles VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL PRIMARY KEY,
            role_id INT NOT NULL,
            nom VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_1483A5E9D60322AC ON users (role_id)');

        $this->addSql('CREATE TABLE IF NOT EXISTS cv (
            id INT NOT NULL PRIMARY KEY,
            email_cand_id INT DEFAULT NULL,
            namecv VARCHAR(255) NOT NULL
        )');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_B66FFE92521C886C ON cv (email_cand_id)');

        $this->addSql('CREATE TABLE IF NOT EXISTS job_details (
            id INT NOT NULL PRIMARY KEY,
            email_id INT DEFAULT NULL,
            fichier VARCHAR(255) NOT NULL,
            titre VARCHAR(255) NOT NULL,
            description VARCHAR(500) NOT NULL,
            logo VARCHAR(255) NOT NULL
        )');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_E8C9BC11A832C1C9 ON job_details (email_id)');

        $this->addSql('CREATE TABLE IF NOT EXISTS time (
            id INT NOT NULL PRIMARY KEY,
            duration VARCHAR(255) NOT NULL
        )');

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

        // Foreign keys avec vérification existence
        $this->addSql('ALTER TABLE cv DROP CONSTRAINT IF EXISTS FK_B66FFE92521C886C');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92521C886C FOREIGN KEY (email_cand_id) REFERENCES users (id)');

        $this->addSql('ALTER TABLE job_details DROP CONSTRAINT IF EXISTS FK_E8C9BC11A832C1C9');
        $this->addSql('ALTER TABLE job_details ADD CONSTRAINT FK_E8C9BC11A832C1C9 FOREIGN KEY (email_id) REFERENCES users (id)');

        $this->addSql('ALTER TABLE users DROP CONSTRAINT IF EXISTS FK_1483A5E9D60322AC');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cv DROP CONSTRAINT IF EXISTS FK_B66FFE92521C886C');
        $this->addSql('ALTER TABLE job_details DROP CONSTRAINT IF EXISTS FK_E8C9BC11A832C1C9');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT IF EXISTS FK_1483A5E9D60322AC');

        $this->addSql('DROP TABLE IF EXISTS messenger_messages CASCADE');
        $this->addSql('DROP TABLE IF EXISTS job_details CASCADE');
        $this->addSql('DROP TABLE IF EXISTS cv CASCADE');
        $this->addSql('DROP TABLE IF EXISTS users CASCADE');
        $this->addSql('DROP TABLE IF EXISTS roles CASCADE');
        $this->addSql('DROP TABLE IF EXISTS country CASCADE');
        $this->addSql('DROP TABLE IF EXISTS time CASCADE');

        $this->addSql('DROP SEQUENCE IF EXISTS country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE IF EXISTS cv_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE IF EXISTS job_details_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE IF EXISTS roles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE IF EXISTS time_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE IF EXISTS users_id_seq CASCADE');
    }
}

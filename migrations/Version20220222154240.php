<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222154240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE class_name_subjects (id INT AUTO_INCREMENT NOT NULL, class_name_id INT NOT NULL, subject_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5331AE3B462FB2A (class_name_id), INDEX IDX_5331AE323EDC87 (subject_id), INDEX IDX_5331AE3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE class_name_subjects ADD CONSTRAINT FK_5331AE3B462FB2A FOREIGN KEY (class_name_id) REFERENCES class_names (id)');
        $this->addSql('ALTER TABLE class_name_subjects ADD CONSTRAINT FK_5331AE323EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE class_name_subjects ADD CONSTRAINT FK_5331AE3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE class_name_subjects');
        $this->addSql('ALTER TABLE class_names CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE subjects CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

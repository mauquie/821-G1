<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505204454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE teaching_subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teaching_subject_equipment (teaching_subject_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_17FF0167A1445E43 (teaching_subject_id), INDEX IDX_17FF0167517FE9FE (equipment_id), PRIMARY KEY(teaching_subject_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teaching_subject_equipment ADD CONSTRAINT FK_17FF0167A1445E43 FOREIGN KEY (teaching_subject_id) REFERENCES teaching_subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teaching_subject_equipment ADD CONSTRAINT FK_17FF0167517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment ADD slug VARCHAR(128) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP equipment_slug, CHANGE room room VARCHAR(255) DEFAULT NULL, CHANGE featured_image featured_image VARCHAR(255) DEFAULT NULL, CHANGE equipment_stock stock INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D338D583989D9B62 ON equipment (slug)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teaching_subject_equipment DROP FOREIGN KEY FK_17FF0167A1445E43');
        $this->addSql('DROP TABLE teaching_subject');
        $this->addSql('DROP TABLE teaching_subject_equipment');
        $this->addSql('DROP INDEX UNIQ_D338D583989D9B62 ON equipment');
        $this->addSql('ALTER TABLE equipment ADD equipment_slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP slug, DROP created_at, DROP updated_at, CHANGE room room VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE featured_image featured_image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE stock equipment_stock INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}

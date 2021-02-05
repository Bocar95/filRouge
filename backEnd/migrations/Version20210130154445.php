<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210130154445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_apprenants_apprenant (groupe_apprenants_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_105305B748C29C26 (groupe_apprenants_id), INDEX IDX_105305B7C5697D6D (apprenant_id), PRIMARY KEY(groupe_apprenants_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_apprenants_apprenant ADD CONSTRAINT FK_105305B748C29C26 FOREIGN KEY (groupe_apprenants_id) REFERENCES groupe_apprenants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenants_apprenant ADD CONSTRAINT FK_105305B7C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenants ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe_apprenants ADD CONSTRAINT FK_7FF1185ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_7FF1185ED0C07AFF ON groupe_apprenants (promo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_apprenants_apprenant');
        $this->addSql('ALTER TABLE groupe_apprenants DROP FOREIGN KEY FK_7FF1185ED0C07AFF');
        $this->addSql('DROP INDEX IDX_7FF1185ED0C07AFF ON groupe_apprenants');
        $this->addSql('ALTER TABLE groupe_apprenants DROP promo_id');
    }
}

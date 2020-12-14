<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907005004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_livrable_partiel (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrable_partiel_id INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_8572D6ADC5697D6D (apprenant_id), INDEX IDX_8572D6AD519178C4 (livrable_partiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6ADC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrables_partiels (id)');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462E6409EF73');
        $this->addSql('DROP INDEX IDX_C4EB462E6409EF73 ON apprenant');
        $this->addSql('ALTER TABLE apprenant DROP profil_sortie_id');
        $this->addSql('ALTER TABLE promo_brief DROP FOREIGN KEY FK_F6922C91D7DB67BE');
        $this->addSql('DROP INDEX IDX_F6922C91D7DB67BE ON promo_brief');
        $this->addSql('ALTER TABLE promo_brief DROP promo_brief_apprenant_id');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE apprenant_livrable_partiel');
        $this->addSql('ALTER TABLE apprenant ADD profil_sortie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462E6409EF73 FOREIGN KEY (profil_sortie_id) REFERENCES profil_sortie (id)');
        $this->addSql('CREATE INDEX IDX_C4EB462E6409EF73 ON apprenant (profil_sortie_id)');
        $this->addSql('ALTER TABLE promo_brief DROP FOREIGN KEY FK_F6922C91D0C07AFF');
        $this->addSql('ALTER TABLE promo_brief ADD promo_brief_apprenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91D7DB67BE FOREIGN KEY (promo_brief_apprenant_id) REFERENCES promo_brief_apprenant (id)');
        $this->addSql('CREATE INDEX IDX_F6922C91D7DB67BE ON promo_brief (promo_brief_apprenant_id)');
    }
}

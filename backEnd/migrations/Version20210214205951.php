<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214205951 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFB642B8210 ON promo (admin_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB642B8210');
        $this->addSql('DROP INDEX IDX_B0139AFB642B8210 ON promo');
        $this->addSql('ALTER TABLE promo DROP admin_id');
    }
}

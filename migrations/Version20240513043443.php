<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513043443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491AD5CDBF');
        $this->addSql('DROP INDEX IDX_8D93D6491AD5CDBF ON user');
        $this->addSql('ALTER TABLE user CHANGE cart_id carts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BCB5C6F5 FOREIGN KEY (carts_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BCB5C6F5 ON user (carts_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BCB5C6F5');
        $this->addSql('DROP INDEX IDX_8D93D649BCB5C6F5 ON user');
        $this->addSql('ALTER TABLE user CHANGE carts_id cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6491AD5CDBF ON user (cart_id)');
    }
}

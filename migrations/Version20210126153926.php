<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126153926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE event_reaction (event_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', reaction_id VARCHAR(255) NOT NULL, INDEX IDX_E23BEE2771F7E88B (event_id), INDEX IDX_E23BEE27813C7171 (reaction_id), PRIMARY KEY(event_id, reaction_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE reaction (id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE event_reaction ADD CONSTRAINT FK_E23BEE2771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE event_reaction ADD CONSTRAINT FK_E23BEE27813C7171 FOREIGN KEY (reaction_id) REFERENCES reaction (id) ON DELETE CASCADE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'ALTER TABLE event_reaction DROP FOREIGN KEY FK_E23BEE27813C7171'
        );
        $this->addSql('DROP TABLE event_reaction');
        $this->addSql('DROP TABLE reaction');
    }
}

<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180806185524 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lines_of_command ADD code_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE lines_of_command ADD CONSTRAINT FK_3AA9FD876D2A9BBC FOREIGN KEY (code_product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_3AA9FD876D2A9BBC ON lines_of_command (code_product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lines_of_command DROP FOREIGN KEY FK_3AA9FD876D2A9BBC');
        $this->addSql('DROP INDEX IDX_3AA9FD876D2A9BBC ON lines_of_command');
        $this->addSql('ALTER TABLE lines_of_command DROP code_product_id');
    }
}

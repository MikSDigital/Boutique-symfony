<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180806184437 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command ADD code_id INT NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD427DAFE17 FOREIGN KEY (code_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD427DAFE17 ON command (code_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499FC99709');
        $this->addSql('DROP INDEX IDX_8D93D6499FC99709 ON user');
        $this->addSql('ALTER TABLE user DROP code_user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD427DAFE17');
        $this->addSql('DROP INDEX IDX_8ECAEAD427DAFE17 ON command');
        $this->addSql('ALTER TABLE command DROP code_id');
        $this->addSql('ALTER TABLE user ADD code_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499FC99709 FOREIGN KEY (code_user_id) REFERENCES command (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499FC99709 ON user (code_user_id)');
    }
}

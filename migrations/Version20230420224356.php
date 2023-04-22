<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420224356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, tricks_id INT NOT NULL, category_tricks VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C13B153154 (tricks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_tricks (id INT AUTO_INCREMENT NOT NULL, tricks_id INT NOT NULL, user_id INT NOT NULL, comment_tricks VARCHAR(255) NOT NULL, comment_tricks_created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_2BCA5AD33B153154 (tricks_id), INDEX IDX_2BCA5AD3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE img_tricks (id INT AUTO_INCREMENT NOT NULL, tricks_id INT NOT NULL, img1 VARCHAR(255) NOT NULL, img2 VARCHAR(255) DEFAULT NULL, img3 VARCHAR(255) DEFAULT NULL, img4 VARCHAR(255) DEFAULT NULL, video_tricks VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3CFCB2A13B153154 (tricks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tricks_name VARCHAR(150) NOT NULL, tricks_description LONGTEXT NOT NULL, tricks_created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_E1D902C1B847CBEF (tricks_name), INDEX IDX_E1D902C1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, user_created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE comment_tricks ADD CONSTRAINT FK_2BCA5AD33B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE comment_tricks ADD CONSTRAINT FK_2BCA5AD3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE img_tricks ADD CONSTRAINT FK_3CFCB2A13B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C13B153154');
        $this->addSql('ALTER TABLE comment_tricks DROP FOREIGN KEY FK_2BCA5AD33B153154');
        $this->addSql('ALTER TABLE comment_tricks DROP FOREIGN KEY FK_2BCA5AD3A76ED395');
        $this->addSql('ALTER TABLE img_tricks DROP FOREIGN KEY FK_3CFCB2A13B153154');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment_tricks');
        $this->addSql('DROP TABLE img_tricks');
        $this->addSql('DROP TABLE tricks');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

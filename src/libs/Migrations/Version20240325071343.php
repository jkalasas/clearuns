<?php

declare(strict_types=1);

namespace Clearuns\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325071343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, short_name VARCHAR(10) NOT NULL, department_id INT NOT NULL, UNIQUE INDEX UNIQ_169E6FB95E237E06 (name), INDEX IDX_169E6FB9AE80F5DF (department_id), PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, short_name VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_CD1DE18A5E237E06 (name), PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE faculty_profile (user_id INT NOT NULL, is_adviser TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE TABLE school_year (id INT AUTO_INCREMENT NOT NULL, start_year INT NOT NULL, end_year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, adviser_id INT NOT NULL, course_id INT NOT NULL, school_year_id INT NOT NULL, semester ENUM(\'FIRST\', \'SECOND\', \'SUMMER\'), INDEX IDX_2D737AEF2C63B5D6 (adviser_id), INDEX IDX_2D737AEF591CC992 (course_id), INDEX IDX_2D737AEFD2EECC3F (school_year_id), PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE student_profile (user_id INT NOT NULL, is_irregular TINYINT(1) DEFAULT 0 NOT NULL, year_level INT NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, middle_initial VARCHAR(2) DEFAULT NULL, suffix VARCHAR(10) DEFAULT NULL, is_admin TINYINT(1) DEFAULT 0 NOT NULL, is_faculty TINYINT(1) DEFAULT 0 NOT NULL, is_student TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE faculty_profile ADD CONSTRAINT FK_C0447C55A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF2C63B5D6 FOREIGN KEY (adviser_id) REFERENCES faculty_profile (user_id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFD2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
        $this->addSql('ALTER TABLE student_profile ADD CONSTRAINT FK_6C611FF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9AE80F5DF');
        $this->addSql('ALTER TABLE faculty_profile DROP FOREIGN KEY FK_C0447C55A76ED395');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF2C63B5D6');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF591CC992');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFD2EECC3F');
        $this->addSql('ALTER TABLE student_profile DROP FOREIGN KEY FK_6C611FF7A76ED395');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE faculty_profile');
        $this->addSql('DROP TABLE school_year');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE student_profile');
        $this->addSql('DROP TABLE user');
    }
}

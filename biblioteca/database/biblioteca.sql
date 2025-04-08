-- Script para criar as tabelas da base de dados da biblioteca
-- O script foi utilizado diretamente no PHPMyAdmin para criar as tabelas
CREATE TABLE Livro (
    Livro_ID INT PRIMARY KEY AUTO_INCREMENT,
    Titulo VARCHAR(255) NOT NULL,
    Genero VARCHAR(100),
    Ano_Publicacao INT,
    ISBN VARCHAR(13) UNIQUE NOT NULL
);

CREATE TABLE Leitor (
    Leitor_ID INT PRIMARY KEY AUTO_INCREMENT,
    Primeiro_nome VARCHAR(100) NOT NULL,
    Ultimo_nome VARCHAR(100) NOT NULL,
    Data_Aniversario DATE,
    Morada VARCHAR(255),
    Telemovel VARCHAR(15),
    Email VARCHAR(100) UNIQUE
);

CREATE TABLE Emprestimo (
    Emprestimo_ID INT PRIMARY KEY AUTO_INCREMENT,
    Livro_ID INT,
    Leitor_ID INT,
    Data_Emp DATE NOT NULL,
    Data_Vencimento DATE NOT NULL,
    Date_Entrega DATE,
    FOREIGN KEY (Livro_ID) REFERENCES Livro(Livro_ID),
    FOREIGN KEY (Leitor_ID) REFERENCES Leitor(Leitor_ID)
);

CREATE TABLE Autor (
    Autor_ID INT PRIMARY KEY AUTO_INCREMENT,
    Primeiro_Nome VARCHAR(100) NOT NULL,
    Ultimo_Nome VARCHAR(100) NOT NULL,
    Data_Aniversario DATE
);

CREATE TABLE Livro_Autor (
    ID_LA INT PRIMARY KEY AUTO_INCREMENT,
    Livro_ID INT,
    Autor_ID INT,
    FOREIGN KEY (Livro_ID) REFERENCES Livro(Livro_ID),
    FOREIGN KEY (Autor_ID) REFERENCES Autor(Autor_ID)
);

-- Creación de la base de datos (si no existe) y selección de la misma
CREATE DATABASE IF NOT EXISTS quizz;
USE quizz;

-- Tabla de Usuarios: Se almacenan las contraseñas de forma encriptada (hash)
CREATE TABLE IF NOT EXISTS Usuarios (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL  -- Almacena el hash de la contraseña
);

-- Tabla de Cuestionarios
CREATE TABLE IF NOT EXISTS Cuestionarios (
    quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT
);

-- Tabla de Preguntas: Cada pregunta pertenece a un cuestionario (clave foránea)
CREATE TABLE IF NOT EXISTS Preguntas (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL, -- Se espera 'A', 'B', 'C' o 'D'
    FOREIGN KEY (quiz_id) REFERENCES Cuestionarios(quiz_id),
    CONSTRAINT chk_correct_option CHECK (correct_option IN ('A', 'B', 'C', 'D'))
);

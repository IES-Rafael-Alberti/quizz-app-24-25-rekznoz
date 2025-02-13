CREATE DATABASE quiz;
USE quiz;

-- Tabla de Usuarios
CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    secreto VARCHAR(255) NOT NULL,
    rol ENUM('estudiante', 'instructor', 'admin') NOT NULL DEFAULT 'estudiante',
    fecha_creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Cuestionarios
CREATE TABLE quizzes (
    quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_by INT NOT NULL,
    fecha_creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES usuarios(user_id) ON DELETE CASCADE
);

-- Tabla de Preguntas
CREATE TABLE preguntas (
    pregunta_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    pregunta_texto TEXT NOT NULL,
    opcion_a VARCHAR(255) NOT NULL,
    opcion_c VARCHAR(255) NOT NULL,
    opcion_b VARCHAR(255) NOT NULL,
    opcion_d VARCHAR(255) NOT NULL,
    opcion_correcta ENUM('A', 'B', 'C', 'D') NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE
);

-- Tabla de Respuestas de Usuarios
CREATE TABLE usuarios_respuestas (
    respuesta_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    quiz_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    opcion_seleccionada ENUM('A', 'B', 'C', 'D') NOT NULL,
    es_correcto BOOLEAN NOT NULL,
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(pregunta_id) ON DELETE CASCADE
);

-- Tabla de Resultados de los Cuestionarios
CREATE TABLE quiz_resultados (
    resultado_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    quiz_id INT NOT NULL,
    puntuacion INT NOT NULL, -- Número de respuestas correctas
    total_preguntas INT NOT NULL,
    porcentaje FLOAT NOT NULL, -- % de aciertos
    fecha_comletado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES preguntas(quiz_id) ON DELETE CASCADE
);

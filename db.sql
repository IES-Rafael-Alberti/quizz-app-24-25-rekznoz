CREATE DATABASE quizz;
USE quizz;

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
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    creado_por INT NOT NULL,
    fecha_creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla de Preguntas
CREATE TABLE preguntas (
    pregunta_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    pregunta_texto TEXT NOT NULL,
    opcion_a VARCHAR(255) NOT NULL,
    opcion_b VARCHAR(255) NOT NULL,
    opcion_c VARCHAR(255) NOT NULL,
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
    intentos INT NOT NULL,
    puntuacion INT NOT NULL, -- Número de respuestas correctas
    total_preguntas INT NOT NULL,
    porcentaje FLOAT NOT NULL, -- % de aciertos
    fecha_completado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE
);

-- Insertar un quiz sobre juegos
INSERT INTO quizzes (titulo, descripcion, creado_por)
VALUES ('Trivia de Videojuegos', 'Un quiz sobre videojuegos populares y clásicos.', 1);

-- Insertar preguntas para el quiz de videojuegos
INSERT INTO preguntas (quiz_id, pregunta_texto, opcion_a, opcion_b, opcion_c, opcion_d, opcion_correcta)
VALUES
    (1, '¿Quién es el protagonista principal de "The Legend of Zelda"?', 'Link', 'Zelda', 'Ganon', 'Epona', 'A'),
    (1, '¿En qué año se lanzó "Super Mario Bros" para la NES?', '1983', '1985', '1987', '1989', 'B'),
    (1, '¿Cuál es el nombre del planeta en "Metroid"?', 'Zebes', 'Samus', 'Crateria', 'Norion', 'A'),
    (1, '¿Qué juego popular introdujo el Battle Royale?', 'Fortnite', 'PUBG', 'Apex Legends', 'Call of Duty', 'B'),
    (1, '¿En qué franquicia aparece el personaje "Master Chief"?', 'Halo', 'Destiny', 'Gears of War', 'Warframe', 'A');

INSERT INTO quizzes (titulo, descripcion, creado_por) VALUES
    ('Fundamentos de Programación', 'Prueba tus conocimientos básicos en programación.', 2);
INSERT INTO preguntas (quiz_id, pregunta_texto, opcion_a, opcion_b, opcion_c, opcion_d, opcion_correcta) VALUES
     (2, '¿Qué significa SQL?', 'Structured Query Language', 'Simple Query Logic', 'Sequential Question Language', 'Standard Query Link', 'A'),
     (2, '¿Cuál de estos lenguajes es de tipado estático?', 'JavaScript', 'Python', 'Java', 'PHP', 'C'),
     (2, '¿Qué estructura de datos utiliza el algoritmo de búsqueda binaria?', 'Lista enlazada', 'Árbol binario', 'Arreglo ordenado', 'Pila', 'C'),
     (2, '¿Qué palabra clave se usa para definir una constante en JavaScript (ES6+)?', 'var', 'let', 'const', 'define', 'C'),
     (2, '¿Qué paradigma de programación utiliza principalmente Prolog?', 'Imperativo', 'Orientado a objetos', 'Lógico', 'Funcional', 'C');

-- Creación del quiz
INSERT INTO quizzes (titulo, descripcion, creado_por)
VALUES ('Conocimiento sobre Comidas', 'Un quiz para poner a prueba tus conocimientos sobre comidas y gastronomía', 1);

-- Obtener el ID del quiz recién creado (en este caso, se asume que el quiz_id es 1, ajusta según sea necesario)
-- Agregar preguntas relacionadas con comidas
INSERT INTO preguntas (quiz_id, pregunta_texto, opcion_a, opcion_b, opcion_c, opcion_d, opcion_correcta)
VALUES
    (3, '¿Cuál es el ingrediente principal del guacamole?', 'Aguacate', 'Tomate', 'Cebolla', 'Pimiento', 'A'),
    (3, '¿De qué país es originario el sushi?', 'China', 'Japón', 'Corea del Sur', 'Tailandia', 'B'),
    (3, '¿Qué tipo de pasta es la más popular en Italia?', 'Fusilli', 'Spaghetti', 'Macarrones', 'Lasaña', 'B'),
    (3, '¿Qué carne se utiliza comúnmente para hacer un taco al pastor?', 'Pollo', 'Cerdo', 'Res', 'Pavo', 'B'),
    (3, '¿Cuál de estos es un postre típico de Francia?', 'Tiramisu', 'Baklava', 'Croissant', 'Crêpes', 'D');

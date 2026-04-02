-- =============================================
-- CRUD Task Manager - Base de datos
-- By Anthoyny Guzman
-- =============================================

CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

CREATE TABLE IF NOT EXISTS tasks (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(100)  NOT NULL,
    description TEXT          NULL,
    status      ENUM('pending','in-progress','completed') NOT NULL DEFAULT 'pending',
    priority    ENUM('low','medium','high')               NOT NULL DEFAULT 'medium',
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos de prueba
INSERT INTO tasks (title, description, status, priority) VALUES
('Comprar comida', 'Ir al supermercado a comprar arroz, pollo y vegetales', 'pending', 'medium'),
('Hacer ejercicio', 'Rutina de gimnasio por 1 hora', 'completed', 'high'),
('Llamar a mamá', 'Hablar con mamá para saber cómo está', 'pending', 'low'),
('Pagar la luz', 'Realizar el pago de la factura eléctrica', 'completed', 'high'),
('Estudiar programación', 'Repasar Git y JavaScript por 2 horas', 'in-progress', 'high'),
('Limpiar la casa', 'Barrer, trapear y organizar la habitación', 'pending', 'medium'),
('Lavar la ropa', 'Poner la lavadora y tender la ropa', 'completed', 'medium'),
('Hacer tarea', 'Completar la tarea de Programación 3', 'in-progress', 'high'),
('Salir con amigos', 'Ir al cine o a cenar', 'pending', 'low'),
('Preparar comida', 'Cocinar el almuerzo del día', 'completed', 'medium');

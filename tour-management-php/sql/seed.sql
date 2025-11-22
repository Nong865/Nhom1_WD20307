USE duan1;

-- roles
INSERT INTO roles (name) VALUES ('ADMIN'), ('GUIDE');

-- users: password is 'admin123' and 'guide123' hashed with PHP password_hash (bcrypt)
-- For convenience we store pre-hashed values produced by PHP's password_hash
-- admin -> admin123
INSERT INTO users (username, password, role_id, full_name) VALUES
('admin', '$2y$10$w9lQJ2q8E3fYH8m1fTqvWeJf7KqKqv3C1ZQk3o1r9gq9o9VQx8bqK', 1, 'Administrator'),
('guide', '$2y$10$4q7eKp9uVf2N2z0Qh6sYfeuP9d1r9tZ2Wq3p1s5J8k2L0mN4b3c7e', 2, 'Hướng dẫn viên');

-- tours
INSERT INTO tours (name, price, description, start_date, end_date) VALUES
('Hà Nội - Hạ Long 2 ngày', 2500000, 'Tham quan Hạ Long, chèo thuyền và thưởng thức hải sản.', '2025-12-01', '2025-12-02'),
('Đà Nẵng - Hội An 3 ngày', 3200000, 'Thăm các điểm nổi tiếng: Bà Nà, Cầu Vàng, Hội An cổ.', '2025-12-05', '2025-12-07');

-- bookings (sample)
INSERT INTO bookings (tour_id, user_id, seats, total_price, status) VALUES
(1, 1, 2, 5000000, 'booked');

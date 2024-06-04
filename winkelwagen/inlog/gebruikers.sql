CREATE TABLE `gebruiker` (
    `id` int(5) NOT NULL,
    `username` varchar(255),
    `password` varchar(255),
    `email` varchar(255)
)ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

INSERT INTO `gebruikers` (`id`, `username`, `password`) VALUES 
(11, 'admin', '$2y$10$DRWxvxqFCm22YolNx4HAC.KXKh76nCohIh4vZ9IMUEnZxfVGyFio');
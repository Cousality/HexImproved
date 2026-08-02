CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  isadmin tinyint(1) NOT NULL DEFAULT 0,
  level int(11) NOT NULL DEFAULT 1,
  updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE games (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    player1_id INT UNSIGNED NOT NULL,
    player2_id INT UNSIGNED NULL,
    board JSON NOT NULL,
    current_turn INT UNSIGNED NOT NULL,
    winner_id INT UNSIGNED NULL,
    status ENUM('waiting', 'active', 'finished') NOT NULL DEFAULT 'waiting',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_games_player1 FOREIGN KEY (player1_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_games_player2 FOREIGN KEY (player2_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_games_winner FOREIGN KEY (winner_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_games_current_turn FOREIGN KEY (current_turn) REFERENCES users(id) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
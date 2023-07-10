CREATE TABLE project_users (
user_id int auto_increment primary key,
name VARCHAR(50),
email VARCHAR(50),
password VARCHAR(10),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE project_inventory (
inventory_id VARCHAR(5) primary key,
name VARCHAR(50),
description VARCHAR(50),
quantity int,
user_id int,
CONSTRAINT fk_user
FOREIGN KEY (user_id)
REFERENCES `n01534088`.project_users(user_id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE project_transactions (
transaction_id int auto_increment primary key,
inventory_id VARCHAR(5),
user_id int,
type VARCHAR(50),
quantity int,
CONSTRAINT fk_user2
FOREIGN KEY (user_id)
REFERENCES `n01534088`.project_users(user_id),
CONSTRAINT fk_inventory
FOREIGN KEY (inventory_id)
REFERENCES `n01534088`.project_inventory(inventory_id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

select _ from `n01534088`.project_users;
select _ from `n01534088`.project_inventory;
select \* from `n01534088`.project_transactions;
drop table `n01534088`.project_users;
drop table `n01534088`.project_inventory;
drop table `n01534088`.project_transactions;

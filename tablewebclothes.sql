-- Tạo bảng `products`
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    rating FLOAT CHECK (rating >= 0 AND rating <= 5) DEFAULT 0
);

-- Tạo bảng `users`
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE (username)
);

-- Tạo bảng `orders` để lưu thông tin đơn hàng
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,         -- ID đơn hàng
    user_id INT NOT NULL, 
    username VARCHAR(50) NOT NULL,
    address1 VARCHAR(255),
    phone VARCHAR(20),
    description VARCHAR(255),                        -- Sửa từ 'descripttion' thành 'description'
    total_price DECIMAL(10, 2) NOT NULL,             -- Tổng giá trị đơn hàng
    status VARCHAR(50) DEFAULT 'pending',            -- Trạng thái đơn hàng (pending, completed, canceled, v.v.)
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Ngày đặt hàng
    FOREIGN KEY (user_id) REFERENCES users(id)       -- Ràng buộc khóa ngoại liên kết với bảng users
);



--6. Bảng order_items - Chi tiết sản phẩm trong từng đơn hàng
CREATE TABLE order_items (
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

--7.Bảng cart - Giỏ hàng tạm của người dùng
CREATE TABLE cart (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image VARCHAR(255),
    price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,             -- Tổng giá trị đơn hàng
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);


--8. Bảng reviews - Đánh giá sản phẩm
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


--9. Bảng addresses - Địa chỉ giao hàng của người dùng  (checkout)
CREATE TABLE addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address1 VARCHAR(255),
    phone VARCHAR(20),
    descripttion VARCHAR(255)
    FOREIGN KEY (user_id) REFERENCES users(id)
);


--10. Bảng payments - Lưu thông tin thanh toán của đơn hàng(checkout)
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('credit_card', 'paypal', 'cash_on_delivery'),
    status ENUM('paid', 'failed', 'pending') DEFAULT 'pending',
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50);

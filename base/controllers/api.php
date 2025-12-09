<?php
// BƯỚC 1: NHÚNG CÁC TỆP CẦN THIẾT
// Đảm bảo rằng bạn nhúng file kết nối DB và file Model cần thiết (ví dụ: ItineraryModel)
// require_once '../config/database.php';
// require_once '../models/ItineraryModel.php';

// Tùy chỉnh headers để đảm bảo trình duyệt biết đây là phản hồi JSON
header('Content-Type: application/json');

// Kiểm tra hành động và tham số tour_id
if (isset($_GET['action']) && $_GET['action'] == 'getItinerary' && isset($_GET['tour_id'])) {
    
    $tour_id = filter_var($_GET['tour_id'], FILTER_VALIDATE_INT);

    if ($tour_id === false || $tour_id <= 0) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Tour ID không hợp lệ.']);
        exit;
    }

    // BƯỚC 2: TRUY VẤN DỮ LIỆU TỪ DATABASE
    try {
        // --- PHẦN KẾT NỐI DB VÀ TRUY VẤN CỦA BẠN ---
        // Giả định bạn có đối tượng $pdo là kết nối DB
        // Giả định bạn có thể gọi Model để thực hiện truy vấn

        // Truy vấn bảng tour_itineraries
        $sql = "SELECT day_number, title, details 
                FROM tour_itineraries 
                WHERE tour_id = :tour_id 
                ORDER BY day_number ASC";
        
        // --- THỰC HIỆN TRUY VẤN (Cần thay thế bằng code DB thực tế) ---
        // Ví dụ PDO:
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
        // $stmt->execute();
        // $itinerary_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // *** DỮ LIỆU MẪU ĐỂ CHẠY THỬ (Sau khi DB hoạt động thì xóa) ***
        $itinerary_data = [];
        if ($tour_id == 1) {
             $itinerary_data = [
                 ['day_number' => 1, 'title' => 'Hà Nội - Vịnh Hạ Long', 'details' => 'Sáng: Khởi hành từ Hà Nội. Chiều: Lên du thuyền...'],
                 ['day_number' => 2, 'title' => 'Vịnh Hạ Long - Hà Nội', 'details' => 'Sáng: Ăn sáng, chèo thuyền Kayak. Chiều: Xe đưa về Hà Nội.'],
             ];
        } 
        // *** KẾT THÚC DỮ LIỆU MẪU ***
        
        // BƯỚC 3: TRẢ VỀ KẾT QUẢ DƯỚI DẠNG JSON
        echo json_encode(['success' => true, 'itinerary' => $itinerary_data], JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Lỗi server khi truy vấn dữ liệu: ' . $e->getMessage()]);
    }
    
} else {
    http_response_code(404); // Not Found
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
}
exit;
?>
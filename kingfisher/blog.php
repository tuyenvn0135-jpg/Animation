<?php 
require_once 'config.php';
include_once 'header.php';

// Thực hiện truy vấn dữ liệu bài viết
$blogs = $conn->query("SELECT * FROM blogs ORDER BY id DESC");
?>

<div class="container mx-auto px-4 py-10 max-w-5xl">
    <div class="text-center max-w-xl mx-auto mb-10">
        <h2 class="text-3xl font-black text-gray-800 tracking-tight">CẨM NANG CẦN THỦ chuyên sâu</h2>
        [cite_start]<p class="text-gray-500 text-xs mt-2 font-medium">Nơi chia sẻ kỹ thuật câu lure, câu đài, cách phối trộn mồi bén và bí quyết bảo dưỡng thiết bị cao cấp từ các chuyên gia lâu năm[cite: 5, 64].</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php 
        // Kiểm tra biến $blogs có dữ liệu hợp lệ hay không trước khi gọi hàm fetch_assoc
        if ($blogs && $blogs->num_rows > 0) {
            while($item = $blogs->fetch_assoc()) {
        ?>
            <article class="bg-white rounded-xl overflow-hidden border shadow-sm flex flex-col justify-between">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" class="w-full h-48 object-cover" alt="Thế giới cần câu">
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">📅 Đăng ngày: <?php echo date('d/m/Y', strtotime($item['created_at'])); ?></span>
                        <h3 class="font-extrabold text-base text-gray-900 mt-1 mb-2 hover:text-[#0A2540] cursor-pointer"><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p class="text-xs text-gray-500 leading-relaxed font-normal"><?php echo htmlspecialchars($item['summary']); ?></p>
                    </div>
                    <div class="mt-4 pt-3 border-t">
                        <a href="#" onclick="alert('Tính năng đọc bài viết chi tiết đang được đồng bộ nội dung.')" class="text-xs font-bold text-[#0A2540] hover:text-[#FF9F1C] tracking-wide inline-block">ĐỌC BÀI VIẾT KHAI SÁNG →</a>
                    </div>
                </div>
            </article>
        <?php 
            }
        } else {
            echo "<p class='col-span-full text-center text-gray-500 py-10'>Hiện tại chưa có bài viết cẩm nang nào được đăng tải.</p>";
        }
        ?>
    </div>
</div>

<?php include_once 'footer.php'; ?>
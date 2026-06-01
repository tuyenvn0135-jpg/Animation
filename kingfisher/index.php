<?php 
require_once 'config.php';
include_once 'header.php';

// Tiếp nhận tham số tìm kiếm và bộ lọc
$search = isset($_GET['search']) ? $_GET['search'] : '';
$brand_filter = isset($_GET['brand']) ? $_GET['brand'] : '';
$price_filter = isset($_GET['price']) ? $_GET['price'] : '';

// Xây dựng câu lệnh SQL lọc dữ liệu động
$sql = "SELECT * FROM products WHERE 1=1";
if(!empty($search)){
    $sql .= " AND (product_name LIKE '%$search%' OR brand LIKE '%$search%' OR specifications LIKE '%$search%')";
}
if(!empty($brand_filter)){
    $sql .= " AND brand = '$brand_filter'";
}
if(!empty($price_filter)){
    if($price_filter == 'low') $sql .= " AND price < 2000000";
    if($price_filter == 'mid') $sql .= " AND price BETWEEN 2000000 AND 10000000";
    if($price_filter == 'high') $sql .= " AND price > 10000000";
}

$result = $conn->query($sql);
?>

<div class="relative bg-slate-900 h-[380px] md:h-[480px] flex items-center justify-center text-center bg-cover bg-center" style="background-image: linear-gradient(rgba(10,37,64,0.65), rgba(10,37,64,0.65)), url('anh/z7870881359151_c71894ff4289305e2f4867dadf4c89db.jpg');">
    <div class="px-4">
        <span class="bg-[#FF9F1C] text-black text-xs font-bold px-3 py-1 uppercase rounded-full tracking-widest">Premium Fishing Gear</span>
        <h1 class="text-4xl font-black text-white" data-aos="fade-right">
               KINGFISHER - ĐẲNG CẤP CẦN THỦ</h1>
        <p class="text-gray-300 max-w-xl mx-auto text-sm md:text-base font-light mb-6">Phân phối thiết bị câu cá High-end nhập khẩu chính hãng từ Nhật Bản, Mỹ và Đức.</p>
        <a href="#san-pham" class="bg-amber-500 text-black font-bold px-6 py-3 rounded" data-aos="zoom-in">
        Chinh Phục Thử Thách - Mua Ngay</a>
    </div>
</div>

<div id="products-display" class="container mx-auto px-4 py-10 max-w-7xl">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-sm h-fit border border-gray-100">
            <h3 class="font-bold text-gray-800 text-base border-b pb-3 mb-4 flex items-center gap-2">⚙️ BỘ LỌC TÌM KIẾM</h3>
            
            <form action="index.php" method="GET" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-2">Thương hiệu</label>
                    <select name="brand" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-1 focus:ring-[#0A2540] outline-none">
                        <option value="">-- Tất cả thương hiệu --</option>
                        <option value="Shimano" <?php if($brand_filter=='Shimano') echo 'selected'; ?>>Shimano (Nhật)</option>
                        <option value="Daiwa" <?php if($brand_filter=='Daiwa') echo 'selected'; ?>>Daiwa (Nhật)</option>
                        <option value="YGK" <?php if($brand_filter=='YGK') echo 'selected'; ?>>YGK Japan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-2">Mức giá sản phẩm</label>
                    <select name="price" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-1 focus:ring-[#0A2540] outline-none">
                        <option value="">-- Tất cả các giá --</option>
                        <option value="low" <?php if($price_filter=='low') echo 'selected'; ?>>Dưới 2.000.000đ</option>
                        <option value="mid" <?php if($price_filter=='mid') echo 'selected'; ?>>2.000.000đ - 10.000.000đ</option>
                        <option value="high" <?php if($price_filter=='high') echo 'selected'; ?>>Phân khúc High-End (>10Tr)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#0A2540] hover:bg-slate-800 text-white font-semibold text-xs py-2.5 rounded transition uppercase tracking-wider">Áp dụng lọc</button>
                <?php if(!empty($brand_filter) || !empty($price_filter) || !empty($search)): ?>
                    <a href="index.php" class="block text-center text-xs text-red-500 underline mt-2">Xóa tất cả bộ lọc</a>
                <?php endif; ?>
            </form>
        </aside>

        <main class="w-full lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-extrabold text-gray-800 tracking-tight">DANH SÁCH THIẾT BỊ ĐỒ CÂU</h2>
                <span class="text-xs text-gray-500 bg-gray-200 px-2.5 py-1 rounded-full font-medium">Tìm thấy <?php echo $result->num_rows; ?> sản phẩm</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php 
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                    <div class="bg-white rounded-lg overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        
                        <div class="relative">
                            <img src="<?php echo $row['image']; ?>" alt="Đồ câu" class="w-full h-48 object-cover">
                            <span class="absolute top-2 left-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                                <?php echo $row['brand']; ?>
                            </span>
                        </div>
                        
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm line-clamp-2 hover:text-[#0A2540] mb-1">
                                    <a href="detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a>
                                </h3>
                                <p class="text-xs text-gray-500 font-medium mb-3">Xuất xứ: <?php echo $row['origin']; ?></p>
                            </div>
                            
                            <div>
                                <div class="text-base font-extrabold text-[#0A2540] mb-3">
                                    <?php echo number_format($row['price'], 0, ',', '.'); ?> đ
                                </div>
                                <a href="detail.php?id=<?php echo $row['id']; ?>" class="block text-center bg-gray-100 hover:bg-[#FF9F1C] hover:text-black text-gray-800 text-xs font-bold py-2 rounded transition uppercase tracking-wider">
                                    Xem thông số chi tiết
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                } else {
                    echo "<p class='col-span-full text-center text-gray-500 py-10'>Không tìm thấy sản phẩm đồ câu phù hợp với tiêu chí.</p>";
                }
                ?>
            </div>
        </main>

    </div>
</div>

<?php include_once 'footer.php'; ?>
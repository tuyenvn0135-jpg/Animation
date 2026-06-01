<?php 
require_once 'config.php';
include_once 'header.php';

// Tiếp nhận các tham số tìm kiếm và bộ lọc
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$brand_filter = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$price_filter = isset($_GET['price']) ? trim($_GET['price']) : '';
$cat_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Xây dựng câu lệnh SQL lọc dữ liệu động kết hợp tất cả bộ lọc
$sql = "SELECT * FROM products WHERE 1=1";

if(!empty($search)){
    $sql .= " AND (product_name LIKE '%" . $conn->real_escape_string($search) . "%' OR brand LIKE '%" . $conn->real_escape_string($search) . "%')";
}
if(!empty($brand_filter)){
    $sql .= " AND brand = '" . $conn->real_escape_string($brand_filter) . "'";
}
if($cat_id > 0){
    $sql .= " AND category_id = " . $cat_id;
}
if(!empty($price_filter)){
    if($price_filter == 'low') $sql .= " AND price < 2000000";
    if($price_filter == 'mid') $sql .= " AND price BETWEEN 2000000 AND 10000000";
    if($price_filter == 'high') $sql .= " AND price > 10000000";
}

$sql .= " ORDER BY id DESC";
$products = $conn->query($sql);
?>

<!-- Banner chính (Hero Section) -->
<div class="relative bg-slate-900 h-[300px] md:h-[400px] flex items-center justify-center text-center bg-cover bg-center" style="background-image: linear-gradient(rgba(10,37,64,0.65), rgba(10,37,64,0.65)), url('anh/z7870881359151_c71894ff4289305e2f4867dadf4c89db.jpg');">
    <div class="px-4">
        <span class="bg-[#FF9F1C] text-black text-xs font-bold px-3 py-1 uppercase rounded-full tracking-widest">Premium Fishing Gear</span>
        <h1 class="text-3xl md:text-4xl font-black text-white mt-3" data-aos="fade-right">KINGFISHER - ĐẲNG CẤP CẦN THỦ</h1>
        <p class="text-gray-300 max-w-xl mx-auto text-xs md:text-sm font-light mt-2 mb-6">Phân phối thiết bị câu cá High-end nhập khẩu chính hãng từ Nhật Bản, Mỹ và Đức.</p>
        <a href="#products-display" class="bg-amber-500 text-black font-bold px-6 py-3 rounded text-xs uppercase transition tracking-wider" data-aos="zoom-in">Chinh Phục Thử Thách - Mua Ngay</a>
    </div>
</div>

<!-- Thân trang chính -->
<div id="products-display" class="container mx-auto px-4 py-10 max-w-7xl">
    
    <!-- Thanh Tìm kiếm và Lọc danh mục nằm ngang phía trên -->
    <form action="index.php" method="GET" class="flex flex-col sm:flex-row gap-4 bg-white p-4 rounded-xl border shadow-sm mb-8" data-aos="fade-down">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm cần câu, máy câu, mồi lure..." class="flex-1 border p-2.5 rounded-lg text-sm outline-none focus:border-blue-500">
        <select name="category_id" class="border p-2.5 rounded-lg text-sm outline-none bg-gray-50 text-gray-700">
            <option value="0">Tất cả danh mục đồ câu</option>
            <?php 
            $cats = $conn->query("SELECT * FROM categories");
            while($c = $cats->fetch_assoc()) {
                $selected = ($c['id'] == $cat_id) ? 'selected' : '';
                echo "<option value='{$c['id']}' {$selected}>{$c['category_name']}</option>";
            }
            ?>
        </select>
        <button type="submit" class="bg-[#0A2540] hover:bg-blue-900 text-white font-bold px-6 py-2.5 rounded-lg text-sm transition">Tìm Kiếm</button>
    </form>

    <!-- Cấu trúc chia cột chính: Trái làm bộ lọc nhỏ, Phải làm Grid sản phẩm hàng ngang -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Bộ lọc nâng cao bên trái -->
        <aside class="w-full lg:w-1/4 bg-white p-6 rounded-xl shadow-sm h-fit border border-gray-100 text-xs font-semibold">
            <h3 class="font-bold text-gray-800 text-sm border-b pb-3 mb-4 flex items-center gap-2">⚙️ BỘ LỌC NÂNG CAO</h3>
            
            <form action="index.php" method="GET" class="space-y-5">
                <!-- Giữ lại các tham số tìm kiếm trước đó nếu có -->
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <input type="hidden" name="category_id" value="<?php echo $cat_id; ?>">

                <div>
                    <label class="block uppercase text-gray-400 mb-2">Thương hiệu</label>
                    <select name="brand" class="w-full border border-gray-300 rounded p-2 text-sm font-normal outline-none focus:border-blue-500 bg-white">
                        <option value="">-- Tất cả thương hiệu --</option>
                        <option value="Shimano" <?php if($brand_filter=='Shimano') echo 'selected'; ?>>Shimano (Nhật)</option>
                        <option value="Daiwa" <?php if($brand_filter=='Daiwa') echo 'selected'; ?>>Daiwa (Nhật)</option>
                        <option value="YGK" <?php if($brand_filter=='YGK') echo 'selected'; ?>>YGK Japan</option>
                    </select>
                </div>

                <div>
                    <label class="block uppercase text-gray-400 mb-2">Mức giá sản phẩm</label>
                    <select name="price" class="w-full border border-gray-300 rounded p-2 text-sm font-normal outline-none focus:border-blue-500 bg-white">
                        <option value="">-- Tất cả các giá --</option>
                        <option value="low" <?php if($price_filter=='low') echo 'selected'; ?>>Dưới 2.000.000đ</option>
                        <option value="mid" <?php if($price_filter=='mid') echo 'selected'; ?>>2.000.000đ - 10.000.000đ</option>
                        <option value="high" <?php if($price_filter=='high') echo 'selected'; ?>>Phân khúc High-End (>10Tr)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#0A2540] hover:bg-slate-800 text-white font-bold py-2.5 rounded transition uppercase tracking-wider text-[11px]">Áp dụng lọc</button>
                <?php if(!empty($brand_filter) || !empty($price_filter) || !empty($search) || $cat_id > 0): ?>
                    <a href="index.php" class="block text-center text-xs text-red-500 underline mt-2 font-normal">Xóa tất cả bộ lọc</a>
                <?php endif; ?>
            </form>
        </aside>

        <!-- Danh sách sản phẩm bên phải hiển thị Hàng Ngang mượt mà -->
        <div class="flex-1">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <?php if($products && $products->num_rows > 0): ?>
                    <?php while($row = $products->fetch_assoc()): ?>
                        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between text-xs font-medium" data-aos="fade-up">
                            <a href="detail.php?id=<?php echo $row['id']; ?>" class="block">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" class="w-full h-44 object-cover">
                                <div class="p-4">
                                    <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1"><?php echo htmlspecialchars($row['brand']); ?></span>
                                    <h3 class="font-bold text-sm text-gray-900 line-clamp-2 min-h-[40px]"><?php echo htmlspecialchars($row['product_name']); ?></h3>
                                    <div class="text-sm font-black text-red-600 mt-2"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</div>
                                </div>
                            </a>
                            <div class="p-4 pt-0">
                                <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="w-full block text-center bg-[#0A2540] text-white py-2 rounded text-[11px] font-bold uppercase hover:bg-blue-900 transition">🛒 Thêm giỏ hàng</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center py-20 bg-white rounded-xl border border-dashed">
                        <p class="text-gray-400 text-sm">Không tìm thấy thiết bị đồ câu nào phù hợp với bộ lọc.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include_once 'footer.php'; ?>
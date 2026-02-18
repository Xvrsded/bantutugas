# Sistem Kalkulasi Harga Otomatis - BantuTugas

## 📋 Overview

Sistem kalkulasi harga otomatis menggunakan **parameter objektif terukur** untuk menentukan harga tugas secara fair dan transparan, mengurangi beban kerja manual admin dan memberikan estimasi harga instan kepada customer.

## 🎯 Tujuan

- ✅ Menghilangkan subjektivitas dalam penentuan harga
- ✅ Memberikan harga instan kepada customer
- ✅ Mengurangi workload admin (tidak perlu kalkulasi manual setiap order)
- ✅ Meningkatkan transparansi dan kepercayaan customer
- ✅ Tetap mempertahankan fleksibilitas untuk adjustment

## 📊 Parameter Kalkulasi

### 1. Jenis Soal/Tugas (Question Type)
**Harga Dasar:**
- Multiple Choice: Rp 5,000 per soal
- Essay/Uraian: Rp 15,000 per soal
- Hitungan/Matematika: Rp 12,000 per soal
- Project/Tugas Besar: Rp 50,000 per project
- Coding/Pemrograman: Rp 75,000 per project

**Skor Kesulitan:**
- Multiple Choice: 10 poin
- Essay: 30 poin
- Calculation: 25 poin
- Project: 50 poin
- Coding: 60 poin

### 2. Mata Pelajaran (Subject Complexity)
**Klasifikasi Otomatis:**
- **High Complexity** (25 poin): Kalkulus, Statistika, Pemrograman, Coding, Algoritma, Fisika Kuantum, Kimia Organik
- **Medium Complexity** (15 poin): Fisika, Kimia, Matematika SMA, Akuntansi, Ekonomi, Biologi
- **Low Complexity** (5 poin): Mata pelajaran lainnya

### 3. Jumlah Soal/Halaman (Quantity)
**Skor Kesulitan:**
- 1-5 soal: 5 poin
- 6-10 soal: 10 poin
- 11-20 soal: 15 poin
- 21+ soal: 20 poin

### 4. Kebutuhan Penjelasan (Explanation)
**Skor Kesulitan:**
- Tidak butuh penjelasan: 0 poin
- Butuh penjelasan detail: 15 poin

### 5. Deadline (Urgency)
**Skor Kesulitan:**
- Santai (>7 hari): 0 poin
- Normal (3-7 hari): 10 poin
- Urgent (1-2 hari): 25 poin
- Very Urgent (<24 jam): 40 poin

## 🧮 Formula Kalkulasi

### Langkah 1: Hitung Total Skor Kesulitan
```
Total Score = Question Type Score + Subject Score + Quantity Score + Explanation Score + Deadline Score
Max Score: 100
```

### Langkah 2: Tentukan Level Kesulitan
- **Easy** (Skor 0-33): Multiplier 1.0x
- **Medium** (Skor 34-66): Multiplier 1.5x
- **Hard** (Skor 67-100): Multiplier 2.2x

### Langkah 3: Hitung Harga
```
Price per Unit = Base Price × Multiplier
Total Price = Price per Unit × Quantity
Final Price = Rounded to nearest 1000 (ceiling)
```

## 💻 Implementasi Teknis

### Backend (Laravel)

**1. Database Schema** (`orders` table):
```php
// Parameter Input
question_type       // string: multiple_choice, essay, calculation, project, coding
subject             // string: nama mata pelajaran
question_count      // integer: jumlah soal/halaman
needs_explanation   // boolean: butuh penjelasan atau tidak
deadline_hours      // integer: deadline dalam jam

// Hasil Kalkulasi
difficulty_score    // integer: total skor (0-100)
difficulty_level    // string: easy, medium, hard
base_price          // decimal: harga dasar per unit
multiplier          // decimal: pengali kesulitan (1.0, 1.5, 2.2)
calculated_price    // decimal: harga hasil kalkulasi
final_price         // decimal: harga final (bisa di-override admin)
price_overridden    // boolean: apakah harga di-override
price_adjustment_reason // text: alasan adjustment (jika ada)
```

**2. PriceCalculator Service** (`app/Services/PriceCalculator.php`):
```php
$calculator = new \App\Services\PriceCalculator();
$result = $calculator->calculate(
    'essay',              // question_type
    'Kalkulus',          // subject
    10,                  // question_count
    true,                // needs_explanation
    48                   // deadline_hours
);

// Returns:
[
    'base_price' => 15000,
    'difficulty_score' => 75,
    'difficulty_level' => 'hard',
    'multiplier' => 2.2,
    'calculated_price' => 330000,
    'price_per_unit' => 33000
]
```

**3. Order Controller** (`app/Http/Controllers/OrderController.php`):
- Validates parameter inputs
- Calculates deadline in hours
- Calls PriceCalculator service
- Saves all parameters and results to database
- Sends notification with calculation breakdown

### Frontend (JavaScript)

**Real-time Calculator** (checkout.blade.php):
```javascript
// Mirrors backend logic exactly
const priceCalculator = {
    calculate(questionType, subject, questionCount, needsExplanation, deadlineHours) {
        // Returns same structure as backend
    }
};

// Updates price display as user fills form
function updatePriceDisplay() {
    const result = priceCalculator.calculate(...);
    // Update UI with calculated price, difficulty level, score
}
```

## 🎨 User Experience

### Checkout Flow:
1. Customer fills in parameter form:
   - Select jenis soal (dropdown)
   - Input mata pelajaran (text)
   - Input jumlah soal (number)
   - Check penjelasan detail (checkbox)
   - Select deadline (datetime)
   
2. **Price updates in real-time** as they type
   - Shows difficulty level badge (Easy/Medium/Hard)
   - Shows difficulty score (0-100)
   - Shows calculated price prominently
   - Shows price per unit

3. Upload file tugas (required)

4. Submit order with calculated price

### Admin Experience:
1. Receives notification with:
   - All parameter values
   - Complete calculation breakdown
   - Final calculated price
   - Link to download customer file

2. Review file to verify accuracy

3. Options:
   - ✅ Accept calculated price (most cases)
   - 🔧 Override price if file doesn't match parameters
   - 📝 Add adjustment reason

## 📝 Admin Override Functionality

**When to Override:**
- File complexity berbeda dari deskripsi parameter
- Ada faktor tambahan yang tidak tercakup parameter
- Customer salah input parameter

**How to Override:**
```php
// Via Admin Panel (to be implemented)
$order->update([
    'final_price' => 400000,  // Override price
    'price_overridden' => true,
    'price_adjustment_reason' => 'File lebih kompleks dari yang dijelaskan, butuh 3 hari pengerjaan'
]);
```

## 🔄 Price Adjustment Clause

**Disclaimer untuk Customer:**
> "Harga dihitung otomatis berdasarkan parameter yang Anda masukkan. Jika setelah review file kami menemukan perbedaan signifikan dari deskripsi, harga dapat disesuaikan dan akan dikonfirmasi via WhatsApp sebelum pengerjaan dimulai."

## 📈 Keuntungan Sistem

### Untuk Business:
- ⚡ **Instant Pricing**: Customer langsung tahu estimasi harga
- 🤖 **Automation**: Mengurangi 80% waktu admin untuk kalkulasi manual
- 📊 **Consistency**: Harga konsisten untuk parameter yang sama
- 💡 **Scalability**: Mudah handle volume order tinggi
- 📈 **Data-Driven**: Analytics untuk optimasi pricing strategy

### Untuk Customer:
- 🎯 **Transparency**: Jelas kenapa harga segitu
- ⚡ **Speed**: Tidak perlu tunggu konfirmasi harga dari admin
- 💰 **Fair Pricing**: Berbasis objektif, bukan feeling
- ✅ **Confidence**: Tahu harga di depan sebelum commit

## 🔧 Konfigurasi & Tuning

**Base Prices** dapat disesuaikan di `PriceCalculator.php`:
```php
private const BASE_PRICES = [
    'multiple_choice' => 5000,
    'essay' => 15000,
    // ... adjust sesuai market rate
];
```

**Weights** dapat di-tune berdasarkan data historis:
```php
private const WEIGHTS = [
    'questionType' => [...],
    'subjectComplexity' => [...],
    // ... adjust berdasarkan analisa
];
```

**Multipliers** dapat diubah sesuai strategi pricing:
```php
private const DIFFICULTY_MULTIPLIERS = [
    'easy' => 1.0,
    'medium' => 1.5,
    'hard' => 2.2,
];
```

## 🚀 Future Enhancements

- [ ] Admin dashboard untuk review calculations
- [ ] Price override interface di admin panel
- [ ] Historical data analysis untuk optimize weights
- [ ] A/B testing different multiplier strategies
- [ ] Machine learning untuk predict actual time vs calculated
- [ ] Customer feedback on price accuracy
- [ ] Automatic price updates based on demand/supply

## 📞 Support & Maintenance

**WhatsApp:** 088991796535  
**Email:** support@bantutugas.com  
**GitHub:** https://github.com/Xvrsded/bantutugas

---

**Version:** 1.0.0  
**Last Updated:** February 18, 2026  
**Status:** ✅ Production Ready

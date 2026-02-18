# 🧪 Quick Testing Guide - Pricing System

## Test URLs

### Access Checkout for Each Service

```
http://localhost:8000/checkout?service=1   # Tugas SMA
http://localhost:8000/checkout?service=2   # Tugas Kuliah
http://localhost:8000/checkout?service=3   # Makalah
http://localhost:8000/checkout?service=4   # Skripsi
http://localhost:8000/checkout?service=5   # Tesis
http://localhost:8000/checkout?service=6   # Revisi
```

---

## Test Scenarios

### Scenario 1: Makalah Standar (Most Common)
1. Go to `/checkout?service=3` (Makalah)
2. Select **Paket Standar** (Rp 8.000/halaman)
3. Enter **15 halaman**
4. Expected Total: **Rp 120.000**
5. ✅ Verify:
   - Unit shows `/halaman`
   - Features include "1x revisi gratis"
   - Calculation is correct

### Scenario 2: Skripsi Premium (Complex)
1. Go to `/checkout?service=4` (Skripsi)
2. Select **Paket Premium** (Rp 18.000/halaman)
3. Enter **80 halaman** (minimum)
4. Expected Total: **Rp 1.440.000**
5. ✅ Verify:
   - Min quantity enforced (min 50 halaman)
   - Features include "2x revisi gratis"
   - Priority deadline mentioned

### Scenario 3: Tugas SMA Quick Order
1. Go to `/checkout?service=1` (Tugas SMA)
2. Select **Paket Hemat** (Rp 25.000/paket)
3. Enter **1 paket** (quantity can be 1)
4. Expected Total: **Rp 25.000**
5. ✅ Verify:
   - Unit shows `/paket` (NOT `/halaman`)
   - Min quantity is 1
   - Total calculation instant

### Scenario 4: Add-ons Integration
1. Any checkout page
2. Add optional add-ons (Rush delivery, etc)
3. ✅ Verify:
   - Add-ons price added to breakdown
   - Total recalculates
   - Add-ons display in summary

---

## Database Queries (Verification)

### Check All Packages
```bash
cd c:\Users\62813\Downloads\bantutugas
sqlite3 database/database.sqlite "SELECT s.name, p.name, p.price_per_unit, p.unit_label, p.min_quantity FROM packages p JOIN services s ON p.service_id = s.id ORDER BY s.id, p.sort_order;"
```

### Check Specific Service Pricing
```bash
# Makalah pricing
sqlite3 database/database.sqlite "SELECT p.name, p.price_per_unit, p.unit_label FROM packages p WHERE p.service_id = 3 ORDER BY p.sort_order;"
```

### Verify Unit Labels
```bash
sqlite3 database/database.sqlite "SELECT DISTINCT unit_label FROM packages;"
```

Expected output:
```
halaman
paket
```

---

## Visual Verification Checklist

### ✅ Pricing Cards
- [ ] 3 cards visible (Hemat, Standar, Premium)
- [ ] Standar has "PALING POPULER" badge
- [ ] Prices formatted with Rp prefix
- [ ] Unit label shows correct type

### ✅ Form Fields
- [ ] Customer info at TOP
- [ ] Quantity input shows min value
- [ ] File upload working
- [ ] Submit button disabled until package selected

### ✅ Order Summary (Right Panel)
- [ ] Package name shows selected option
- [ ] Breakdown calculation correct
- [ ] Total updates in real-time
- [ ] Add-ons section appears when selected

### ✅ Mobile Responsive
- [ ] 1 column layout on mobile
- [ ] Summary moves below on small screens
- [ ] Touch-friendly buttons
- [ ] Form still usable

---

## Example Calculations

### Makalah - Different Quantities

| Paket | Per Unit | Qty | Total |
|-------|----------|-----|-------|
| Hemat | 5k | 5 | 25k |
| Hemat | 5k | 20 | 100k |
| Standar | 8k | 10 | 80k |
| Standar | 8k | 15 | 120k |
| Premium | 12k | 5 | 60k |
| Premium | 12k | 20 | 240k |

### Skripsi - Minimum Requirements

| Paket | Per Unit | Min | Min Total |
|-------|----------|-----|-----------|
| Hemat | 8k | 50 | 400k |
| Standar | 12k | 50 | 600k |
| Premium | 18k | 50 | 900k |

### Tugas - Per Paket

| Service | Paket | Harga | Qty | Total |
|---------|-------|-------|-----|-------|
| Tugas SMA | Hemat | 25k | 1-5 | 25-125k |
| Tugas SMA | Premium | 60k | 1-5 | 60-300k |
| Tugas Kuliah | Standar | 55k | 1-3 | 55-165k |

---

## Troubleshooting

### Issue: Unit label shows "unit" instead of "halaman"
**Solution**: Cache not cleared. Run:
```bash
php artisan view:clear && php artisan cache:clear
```

### Issue: Prices showing old values (7.5k instead of 5k)
**Solution**: Database not re-seeded. Run:
```bash
php artisan migrate:fresh --seed
```

### Issue: 3rd package not showing
**Solution**: Check is_active flag in database:
```bash
sqlite3 database/database.sqlite "SELECT * FROM packages WHERE is_active = 0;"
```

### Issue: Min quantity not enforced
**Solution**: Check checkout-package.blade.php line that uses `min_quantity`:
```blade
<div class="min-info" id="min-qty-info">
    Min. {{ $package->min_quantity }} {{ $package->unit_label }}
</div>
```

---

## Browser Console Check

Open Developer Tools (F12) and check console for any JavaScript errors:

```javascript
// Should work without errors:
console.log(document.querySelectorAll('.pricing-card').length); // Should be 3

// Check data attributes:
console.log(document.querySelector('.pricing-card').dataset);
// Should show: {packageId: "1", price: "5000", minQty: "5"}
```

---

## Performance Check

### Page Load Time
- Should load in < 2 seconds
- CSS/JS properly bundled
- No 404 errors for assets

### Calculation Performance
- Quantity change should update total instantly
- Add-on toggle should recalculate immediately
- No lag or flickering

### Mobile Performance
- Touch interactions responsive
- No zoom/scroll issues
- Forms work on mobile keyboard

---

## Final Validation

After testing all scenarios:

- [ ] All 6 services accessible
- [ ] 3 packages per service visible
- [ ] Correct pricing displayed
- [ ] Unit labels dynamic and correct
- [ ] Calculations accurate
- [ ] Responsive on mobile/desktop
- [ ] Form submission works
- [ ] Add-ons working
- [ ] Summary updates real-time
- [ ] No console errors

---

**Status**: Ready for Production ✅
**Last Tested**: 2026-02-20
**Git Commits**: 2 (pricing redesign + implementation report)

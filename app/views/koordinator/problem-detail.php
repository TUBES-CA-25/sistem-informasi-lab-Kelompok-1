<?php $title = 'Koordinator - Problem Detail'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh;">
    <!-- Sidebar -->
    <div style="width: 250px; background: #1e293b; color: white; padding: 1.5rem;">
        <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ICLABS</div>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/koordinator/dashboard') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Dashboard</a>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/koordinator/problems') ?>" style="color: white; text-decoration: none; display: block; padding: 0.5rem; background: #334155; border-radius: 0.25rem;">All Problems</a>
            </li>
            <li>
                <a href="<?= url('/logout') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Logout</a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div style="flex: 1; background: #f8fafc;">
        <div style="background: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>🔧 Detail Masalah #<?= $problem['id'] ?></h2>
                <p>Informasi lengkap dan riwayat masalah</p>
            </div>
            <a href="/koordinator/problems" class="btn btn-secondary">← Kembali</a>
        </div>
        
        <div style="padding: 2rem;">
            <?php if (hasFlash()): ?>
                <div class="alert alert-<?= getFlash()['type'] ?>">
                    <?= getFlash()['message'] ?>
                </div>
            <?php endif; ?>

            <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 2rem;">
                <!-- Problem Details -->
                <div>
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-body">
                    <h3>📝 Informasi Masalah</h3>
                    
                    <div class="detail-group">
                        <label>Laboratorium:</label>
                        <p><?= htmlspecialchars($problem['lab_name']) ?></p>
                    </div>

                    <div class="detail-group">
                        <label>Lokasi Lab:</label>
                        <p><?= htmlspecialchars($problem['location']) ?></p>
                    </div>

                    <div class="detail-group">
                        <label>PC Number:</label>
                        <p><strong><?= htmlspecialchars($problem['pc_number']) ?></strong></p>
                    </div>

                    <div class="detail-group">
                        <label>Tipe Masalah:</label>
                        <p>
                            <span class="badge badge-secondary">
                                <?= ucfirst($problem['problem_type']) ?>
                            </span>
                        </p>
                    </div>

                    <div class="detail-group">
                        <label>Status:</label>
                        <p><?= getStatusBadge($problem['status']) ?></p>
                    </div>

                    <div class="detail-group">
                        <label>Deskripsi Lengkap:</label>
                        <p style="white-space: pre-wrap;"><?= htmlspecialchars($problem['description']) ?></p>
                    </div>

                    <div class="detail-group">
                        <label>Dilaporkan Oleh:</label>
                        <p><?= htmlspecialchars($problem['reporter_name']) ?> (<?= htmlspecialchars($problem['reporter_email']) ?>)</p>
                    </div>

                    <div class="detail-group">
                        <label>Tanggal Laporan:</label>
                        <p><?= formatDate($problem['reported_at']) ?></p>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="card">
                <div class="card-body">
                    <h3>📜 Riwayat Update</h3>
                    
                    <?php if (empty($histories)): ?>
                        <div class="empty-state">
                            <p>Belum ada riwayat update</p>
                        </div>
                    <?php else: ?>
                        <div class="timeline">
                            <?php foreach ($histories as $history): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                            <span><?= getStatusBadge($history['status']) ?></span>
                                            <span class="text-muted"><?= formatDate($history['updated_at']) ?></span>
                                        </div>
                                        <?php if (!empty($history['note'])): ?>
                                            <p style="margin: 0; padding: 0.5rem; background: #f8f9fa; border-radius: 4px;">
                                                💬 <?= htmlspecialchars($history['note']) ?>
                                            </p>
                                        <?php endif; ?>
                                        <small class="text-muted">
                                            Oleh: <?= htmlspecialchars($history['updated_by_name']) ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
                </div>

                <!-- Update Status Form -->
                <div>
                    <div class="card" style="position: sticky; top: 2rem;">
                        <div class="card-body">
                            <h3>🔄 Update Status</h3>
                            
                            <form method="POST" action="/koordinator/problems/<?= $problem['id'] ?>/update-status">
                                <div class="form-group">
                                    <label for="status">Status Baru:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="reported" <?= $problem['status'] === 'reported' ? 'selected' : '' ?>>
                                            📝 Dilaporkan
                                        </option>
                                        <option value="in_progress" <?= $problem['status'] === 'in_progress' ? 'selected' : '' ?>>
                                            ⚙️ Dalam Proses
                                        </option>
                                        <option value="resolved" <?= $problem['status'] === 'resolved' ? 'selected' : '' ?>>
                                            ✅ Selesai
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="note">Catatan (opsional):</label>
                                    <textarea name="note" id="note" class="form-control" rows="4" 
                                        placeholder="Tambahkan catatan tentang update ini..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    💾 Simpan Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.detail-group {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.detail-group:last-child {
    border-bottom: none;
}

.detail-group label {
    display: block;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.detail-group p {
    margin: 0;
    color: #212529;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0;
    width: 12px;
    height: 12px;
    background: var(--primary-color);
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px var(--primary-color);
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 12px;
    bottom: -2rem;
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 3px solid var(--primary-color);
}
</style>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

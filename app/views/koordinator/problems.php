<?php $title = 'Koordinator - Problems'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <!-- Sidebar -->
    <div style="width: 260px; background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); color: white; padding: 1.8rem 1.2rem; box-shadow: 4px 0 20px rgba(0,0,0,0.15);">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2.5rem;">
            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); border-radius: 0.8rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                <svg width="24" height="24" fill="white" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
            </div>
            <div style="font-size: 1.5rem; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #8b5cf6); background-clip: text; -webkit-text-fill-color: transparent;">ICLABS</div>
        </div>
        
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 0.6rem;">
                <a href="<?= url('/koordinator/dashboard') ?>" style="color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; border-radius: 0.7rem; transition: all 0.3s; font-weight: 500;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1'">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li style="margin-bottom: 0.6rem;">
                <a href="<?= url('/koordinator/problems') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(139, 92, 246, 0.25)); border-radius: 0.7rem; border-left: 4px solid #3b82f6; font-weight: 600; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                    <span>All Problems</span>
                </a>
            </li>
            <li style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="<?= url('/logout') ?>" style="color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; border-radius: 0.7rem; transition: all 0.3s; font-weight: 500;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'; this.style.color='#f87171'" onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1'">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div style="flex: 1; background: #f8fafc; overflow-y: auto;">
        <!-- Top Bar -->
        <div style="background: white; padding: 1.8rem 2.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 800; margin: 0; background: linear-gradient(135deg, #3b82f6, #8b5cf6); -background-clip: text; -webkit-text-fill-color: transparent;">📋 All Problems</h2>
                    <p style="margin: 0.5rem 0 0 0; color: #64748b; font-size: 0.95rem;">Kelola semua laporan masalah laboratorium</p>
                </div>
                
                <!-- Search & Stats -->
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="position: relative;">
                        <input type="text" id="searchInput" placeholder="Search problems..." style="width: 300px; padding: 0.75rem 1rem 0.75rem 2.8rem; border: 2px solid #e2e8f0; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'" onkeyup="searchProblems()">
                        <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); color: white; padding: 0.75rem 1.2rem; border-radius: 0.8rem; font-weight: 700; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                        <span id="problemCount"><?= count($problems) ?></span> Problems
                    </div>
                </div>
            </div>
        </div>
        
        <div style="padding: 2rem 2.5rem;">
            <?php if (hasFlash()): ?>
                <div style="background: <?= getFlash()['type'] === 'success' ? 'linear-gradient(135deg, #10b981 0%, #34d399 100%)' : 'linear-gradient(135deg, #ef4444 0%, #f87171 100%)' ?>; color: white; padding: 1.2rem 1.5rem; border-radius: 0.8rem; margin-bottom: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-weight: 500;">
                    <?= getFlash()['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Filter Status -->
            <div style="background: white; border-radius: 1.25rem; padding: 1.8rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-bottom: 2rem;">
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #0f172a; margin-bottom: 1.2rem;">Filter by Status</h3>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="<?= BASE_URL ?>/koordinator/problems" style="padding: 0.85rem 1.8rem; border-radius: 0.8rem; text-decoration: none; font-weight: 600; transition: all 0.3s; 
                        <?= !isset($currentStatus) ? 'background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);' : 'background: #f1f5f9; color: #64748b;' ?>" 
                        onmouseover="<?= !isset($currentStatus) ? 'this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 20px rgba(59, 130, 246, 0.4)\'' : 'this.style.background=\'#e2e8f0\'' ?>" 
                        onmouseout="<?= !isset($currentStatus) ? 'this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 4px 12px rgba(59, 130, 246, 0.3)\'' : 'this.style.background=\'#f1f5f9\'' ?>">
                        🔍 All (<?= count($problems) ?>)
                    </a>
                    <a href="<?= BASE_URL ?>/koordinator/problems?status=reported" style="padding: 0.85rem 1.8rem; border-radius: 0.8rem; text-decoration: none; font-weight: 600; transition: all 0.3s; 
                        <?= ($currentStatus ?? '') === 'reported' ? 'background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);' : 'background: #f1f5f9; color: #64748b;' ?>"
                        onmouseover="<?= ($currentStatus ?? '') === 'reported' ? 'this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 20px rgba(245, 158, 11, 0.4)\'' : 'this.style.background=\'#e2e8f0\'' ?>"
                        onmouseout="<?= ($currentStatus ?? '') === 'reported' ? 'this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 4px 12px rgba(245, 158, 11, 0.3)\'' : 'this.style.background=\'#f1f5f9\'' ?>">
                        📋 Reported
                    </a>
                    <a href="<?= BASE_URL ?>/koordinator/problems?status=in_progress" style="padding: 0.85rem 1.8rem; border-radius: 0.8rem; text-decoration: none; font-weight: 600; transition: all 0.3s; 
                        <?= ($currentStatus ?? '') === 'in_progress' ? 'background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);' : 'background: #f1f5f9; color: #64748b;' ?>"
                        onmouseover="<?= ($currentStatus ?? '') === 'in_progress' ? 'this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 20px rgba(59, 130, 246, 0.4)\'' : 'this.style.background=\'#e2e8f0\'' ?>"
                        onmouseout="<?= ($currentStatus ?? '') === 'in_progress' ? 'this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 4px 12px rgba(59, 130, 246, 0.3)\'' : 'this.style.background=\'#f1f5f9\'' ?>">
                        ⚙️ In Progress
                    </a>
                    <a href="<?= BASE_URL ?>/koordinator/problems?status=resolved" style="padding: 0.85rem 1.8rem; border-radius: 0.8rem; text-decoration: none; font-weight: 600; transition: all 0.3s; 
                        <?= ($currentStatus ?? '') === 'resolved' ? 'background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);' : 'background: #f1f5f9; color: #64748b;' ?>"
                        onmouseover="<?= ($currentStatus ?? '') === 'resolved' ? 'this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 20px rgba(16, 185, 129, 0.4)\'' : 'this.style.background=\'#e2e8f0\'' ?>"
                        onmouseout="<?= ($currentStatus ?? '') === 'resolved' ? 'this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 4px 12px rgba(16, 185, 129, 0.3)\'' : 'this.style.background=\'#f1f5f9\'' ?>">
                        ✅ Resolved
                    </a>
                </div>
            </div>

            <!-- Problems List -->
            <div style="background: white; border-radius: 1.25rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                <?php if (empty($problems)): ?>
                    <div style="text-align: center; padding: 4rem 2rem;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                        <div style="font-size: 1.3rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem;">No problems found</div>
                        <div style="font-size: 0.95rem; color: #94a3b8;">Try adjusting your filters or check back later</div>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table id="problemsTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 2px solid #e2e8f0;">
                                    <th onclick="sortTable(0)" style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">
                                        ID <span style="font-size: 0.7rem;">▼▲</span>
                                    </th>
                                    <th onclick="sortTable(1)" style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">
                                        Laboratory <span style="font-size: 0.7rem;">▼▲</span>
                                    </th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">PC</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Reporter</th>
                                    <th onclick="sortTable(6)" style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">
                                        Status <span style="font-size: 0.7rem;">▼▲</span>
                                    </th>
                                    <th onclick="sortTable(7)" style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">
                                        Date <span style="font-size: 0.7rem;">▼▲</span>
                                    </th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: center; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($problems as $problem): ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                        <td style="padding: 1.2rem; font-weight: 700; color: #3b82f6;">#<?= $problem['id'] ?></td>
                                        <td style="padding: 1.2rem; font-weight: 600; color: #1e293b;"><?= htmlspecialchars($problem['lab_name']) ?></td>
                                        <td style="padding: 1.2rem; color: #475569; font-weight: 600;"><?= htmlspecialchars($problem['pc_number']) ?></td>
                                        <td style="padding: 1.2rem;">
                                            <span style="padding: 0.4rem 0.9rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; 
                                                background: <?= $problem['problem_type'] === 'hardware' ? 'rgba(239, 68, 68, 0.15)' : ($problem['problem_type'] === 'software' ? 'rgba(59, 130, 246, 0.15)' : 'rgba(139, 92, 246, 0.15)') ?>; 
                                                color: <?= $problem['problem_type'] === 'hardware' ? '#dc2626' : ($problem['problem_type'] === 'software' ? '#2563eb' : '#7c3aed') ?>;">
                                                <?= ucfirst($problem['problem_type']) ?>
                                            </span>
                                        </td>
                                        <td style="padding: 1.2rem; max-width: 280px; color: #64748b; font-size: 0.9rem; line-height: 1.5;">
                                            <?= htmlspecialchars(substr($problem['description'], 0, 80)) ?>
                                            <?= strlen($problem['description']) > 80 ? '...' : '' ?>
                                        </td>
                                        <td style="padding: 1.2rem;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem;">
                                                    <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                                </div>
                                                <span style="font-weight: 500; color: #1e293b;"><?= htmlspecialchars($problem['reporter_name']) ?></span>
                                            </div>
                                        </td>
                                        <td style="padding: 1.2rem;">
                                            <?= getStatusBadge($problem['status']) ?>
                                        </td>
                                        <td style="padding: 1.2rem; color: #64748b; font-size: 0.9rem;"><?= formatDate($problem['reported_at']) ?></td>
                                        <td style="padding: 1.2rem; text-align: center;">
                                            <a href="<?= BASE_URL ?>/koordinator/problems/<?= $problem['id'] ?>" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.2rem; border-radius: 0.6rem; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: all 0.3s; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(59, 130, 246, 0.25)'">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
function searchProblems() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('problemsTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    let visibleCount = 0;

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        
        if (found) {
            rows[i].style.display = '';
            visibleCount++;
        } else {
            rows[i].style.display = 'none';
        }
    }
    
    document.getElementById('problemCount').textContent = visibleCount;
}

// Sort table functionality
let sortDirections = {};
function sortTable(columnIndex) {
    const table = document.getElementById('problemsTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    // Toggle sort direction
    sortDirections[columnIndex] = !sortDirections[columnIndex];
    const ascending = sortDirections[columnIndex];
    
    rows.sort((a, b) => {
        const aValue = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        const bValue = b.getElementsByTagName('td')[columnIndex].textContent.trim();
        
        // Handle numeric values (ID)
        if (columnIndex === 0) {
            const aNum = parseInt(aValue.replace('#', ''));
            const bNum = parseInt(bValue.replace('#', ''));
            return ascending ? aNum - bNum : bNum - aNum;
        }
        
        // Handle text values
        return ascending 
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
}
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

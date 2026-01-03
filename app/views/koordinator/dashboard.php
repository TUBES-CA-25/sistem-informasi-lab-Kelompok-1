<?php $title = 'Koordinator Dashboard'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh; background: #f1f5f9;">
    <!-- Sidebar -->
    <div style="width: 260px; background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); color: white; padding: 1.5rem; box-shadow: 4px 0 20px rgba(0,0,0,0.15); position: relative;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">I</div>
            <div>
                <div style="font-size: 1.35rem; font-weight: 700; letter-spacing: 0.5px;">ICLABS</div>
                <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase;">Koordinator</div>
            </div>
        </div>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 0.4rem;">
                <a href="<?= url('/koordinator/dashboard') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 0.6rem; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transition: all 0.3s;">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>
                    <span style="font-weight: 600;">Dashboard</span>
                </a>
            </li>
            <li style="margin-bottom: 0.4rem;">
                <a href="<?= url('/koordinator/problems') ?>" style="color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem; border-radius: 0.6rem; transition: all 0.3s;" onmouseover="this.style.background='rgba(51,65,85,0.6)'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1'">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <span style="font-weight: 500;">All Problems</span>
                </a>
            </li>
            <li style="margin-top: 22rem;">
                <a href="<?= url('/logout') ?>" style="color: #ef4444; text-decoration: none; display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem; border-radius: 0.6rem; border: 1px solid rgba(239, 68, 68, 0.3); transition: all 0.3s;" onmouseover="this.style.background='rgba(239,68,68,0.1)'" onmouseout="this.style.background='transparent'">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
                    <span style="font-weight: 500;">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    
    <div style="flex: 1; overflow-y: auto;">
        <!-- Top Bar -->
        <div style="background: white; padding: 1.7rem 2.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; margin: 0; color: #0f172a; background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Dashboard Overview</h1>
                <p style="margin: 0.4rem 0 0 0; color: #64748b; font-size: 0.95rem;">Selamat datang, <strong><?= e($userName) ?></strong> 👋</p>
            </div>
            <div style="display: flex; align-items: center; gap: 1.2rem;">
                <div style="position: relative;">
                    <input type="text" placeholder="Search..." style="padding: 0.65rem 1.1rem 0.65rem 2.7rem; border: 2px solid #e2e8f0; border-radius: 0.6rem; width: 280px; font-size: 0.9rem; transition: all 0.3s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    <svg style="position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/></svg>
                </div>
                <button style="position: relative; padding: 0.65rem; background: #f1f5f9; border: none; border-radius: 0.6rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                    <span style="position: absolute; top: 4px; right: 4px; width: 9px; height: 9px; background: #ef4444; border-radius: 50%; border: 2px solid white; animation: pulse 2s infinite;"></span>
                </button>
                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.05rem; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); cursor: pointer;">
                    <?= strtoupper(substr(getUserName(), 0, 2)) ?>
                </div>
            </div>
        </div>
        
        <div style="padding: 2.5rem;">
            <?php displayFlash(); ?>
            
            <!-- Statistics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 1.7rem; margin-bottom: 2.5rem;">
                <div style="background: white; padding: 1.8rem; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative; overflow: hidden; border: 1px solid #f1f5f9; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 30px rgba(59,130,246,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                    <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); border-radius: 50%; opacity: 0.08;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.2rem;">
                        <div>
                            <div style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.6rem;">Total Problems</div>
                            <div style="font-size: 2.6rem; font-weight: 800; color: #0f172a;"><?= $statistics['total'] ?? 0 ?></div>
                        </div>
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 18px rgba(59, 130, 246, 0.35);">
                            <svg width="28" height="28" fill="white" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.9rem;">
                        <span style="color: #ef4444; font-weight: 700;">↓ 12%</span>
                        <span style="color: #64748b;">dari minggu lalu</span>
                    </div>
                </div>

                <div style="background: white; padding: 1.8rem; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative; overflow: hidden; border: 1px solid #f1f5f9; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 30px rgba(239,68,68,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                    <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); border-radius: 50%; opacity: 0.08;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.2rem;">
                        <div>
                            <div style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.6rem;">Reported</div>
                            <div style="font-size: 2.6rem; font-weight: 800; color: #0f172a;"><?= $statistics['reported'] ?? 0 ?></div>
                        </div>
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 18px rgba(239, 68, 68, 0.35);">
                            <svg width="28" height="28" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.9rem;">
                        <span style="color: #10b981; font-weight: 700;">↑ 8%</span>
                        <span style="color: #64748b;">dari minggu lalu</span>
                    </div>
                </div>

                <div style="background: white; padding: 1.8rem; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative; overflow: hidden; border: 1px solid #f1f5f9; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 30px rgba(245,158,11,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                    <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); border-radius: 50%; opacity: 0.08;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.2rem;">
                        <div>
                            <div style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.6rem;">In Progress</div>
                            <div style="font-size: 2.6rem; font-weight: 800; color: #0f172a;"><?= $statistics['in_progress'] ?? 0 ?></div>
                        </div>
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 18px rgba(245, 158, 11, 0.35);">
                            <svg width="28" height="28" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.9rem;">
                        <span style="color: #64748b; font-weight: 700;">—</span>
                        <span style="color: #64748b;">tidak ada perubahan</span>
                    </div>
                </div>

                <div style="background: white; padding: 1.8rem; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative; overflow: hidden; border: 1px solid #f1f5f9; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 30px rgba(16,185,129,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                    <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); border-radius: 50%; opacity: 0.08;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.2rem;">
                        <div>
                            <div style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.6rem;">Resolved</div>
                            <div style="font-size: 2.6rem; font-weight: 800; color: #0f172a;"><?= $statistics['resolved'] ?? 0 ?></div>
                        </div>
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);">
                            <svg width="28" height="28" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.9rem;">
                        <span style="color: #10b981; font-weight: 700;">↑ 25%</span>
                        <span style="color: #64748b;">dari minggu lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Chart & Quick Actions Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <!-- Problem Distribution Chart -->
                <div style="background: white; border-radius: 1.25rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s ease;">
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem;">Problem Distribution</h3>
                    <div style="position: relative; height: 300px; display: flex; align-items: center; justify-content: center;">
                        <canvas id="problemChart"></canvas>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div style="background: white; border-radius: 1.25rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem;">Quick Actions</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <a href="<?= url('/koordinator/problems?status=reported') ?>" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); padding: 1.5rem; border-radius: 1rem; text-decoration: none; color: white; text-align: center; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(245, 158, 11, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(245, 158, 11, 0.3)'">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📋</div>
                            <div>New Reports</div>
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-top: 0.3rem;"><?= $statistics['reported'] ?? 0 ?> problems</div>
                        </a>
                        
                        <a href="<?= url('/koordinator/problems?status=in_progress') ?>" style="background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); padding: 1.5rem; border-radius: 1rem; text-decoration: none; color: white; text-align: center; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.3)'">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">⚙️</div>
                            <div>In Progress</div>
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-top: 0.3rem;"><?= $statistics['in_progress'] ?? 0 ?> problems</div>
                        </a>
                        
                        <a href="<?= url('/koordinator/problems?status=resolved') ?>" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); padding: 1.5rem; border-radius: 1rem; text-decoration: none; color: white; text-align: center; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.3)'">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">✅</div>
                            <div>Resolved</div>
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-top: 0.3rem;"><?= $statistics['resolved'] ?? 0 ?> problems</div>
                        </a>
                        
                        <a href="<?= url('/koordinator/problems') ?>" style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); padding: 1.5rem; border-radius: 1rem; text-decoration: none; color: white; text-align: center; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)'">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📊</div>
                            <div>View All</div>
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-top: 0.3rem;">All problems</div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Problems Table -->
            <div style="background: white; border-radius: 1.25rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #0f172a;">Recent Problems</h3>
                    <a href="<?= url('/koordinator/problems') ?>" style="color: #3b82f6; font-weight: 600; text-decoration: none; font-size: 0.95rem; transition: color 0.2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#3b82f6'">View All →</a>
                </div>
                
                <?php if (!empty($pendingProblems)): ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Laboratory</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">PC</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Reporter</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: left; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                                    <th style="padding: 1.1rem 1.2rem; text-align: center; font-weight: 700; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingProblems as $problem): ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                        <td style="padding: 1.2rem; font-weight: 600; color: #1e293b;"><?= e($problem['lab_name']) ?></td>
                                        <td style="padding: 1.2rem; color: #475569; font-weight: 600;"><?= e($problem['pc_number']) ?></td>
                                        <td style="padding: 1.2rem;">
                                            <span style="padding: 0.4rem 0.9rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; 
                                                background: <?= $problem['problem_type'] === 'hardware' ? 'rgba(239, 68, 68, 0.15)' : ($problem['problem_type'] === 'software' ? 'rgba(59, 130, 246, 0.15)' : 'rgba(139, 92, 246, 0.15)') ?>; 
                                                color: <?= $problem['problem_type'] === 'hardware' ? '#dc2626' : ($problem['problem_type'] === 'software' ? '#2563eb' : '#7c3aed') ?>;">
                                                <?= getProblemTypeLabel($problem['problem_type']) ?>
                                            </span>
                                        </td>
                                        <td style="padding: 1.2rem;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem;">
                                                    <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                                </div>
                                                <span style="font-weight: 500; color: #1e293b;"><?= e($problem['reporter_name']) ?></span>
                                            </div>
                                        </td>
                                        <td style="padding: 1.2rem;">
                                            <?= getStatusBadge($problem['status']) ?>
                                        </td>
                                        <td style="padding: 1.2rem; color: #64748b; font-size: 0.9rem;"><?= formatDateTime($problem['reported_at']) ?></td>
                                        <td style="padding: 1.2rem; text-align: center;">
                                            <a href="<?= url('/koordinator/problems/' . $problem['id']) ?>" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.2rem; border-radius: 0.6rem; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: all 0.3s; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(59, 130, 246, 0.25)'">View Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: #94a3b8;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #64748b;">No recent problems</div>
                        <div style="font-size: 0.9rem; margin-top: 0.5rem;">All problems have been handled</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Problem Distribution Chart
const ctx = document.getElementById('problemChart');
if (ctx) {
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Reported', 'In Progress', 'Resolved'],
            datasets: [{
                data: [
                    <?= $statistics['reported'] ?? 0 ?>,
                    <?= $statistics['in_progress'] ?? 0 ?>,
                    <?= $statistics['resolved'] ?? 0 ?>
                ],
                backgroundColor: [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)'
                ],
                borderColor: [
                    '#f59e0b',
                    '#3b82f6',
                    '#10b981'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 13,
                            weight: '600'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
}
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

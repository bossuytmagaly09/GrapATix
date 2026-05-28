<div class="h-full flex flex-col justify-between bg-slate-950 pb-safe">
    <!-- Top Nav / Header -->
    <header class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800/60 px-4 py-3 flex items-center justify-between z-10 shrink-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-sm font-bold truncate max-w-[180px]">{{ $event->title }}</h1>
                <p class="text-[10px] text-slate-400 truncate max-w-[180px]">{{ $event->venue->name ?? 'Locatie onbekend' }}</p>
            </div>
        </div>
        
        <!-- Live Stats Badge -->
        <div class="bg-[#00ED64]/10 border border-[#00ED64]/20 rounded-full px-3 py-1 flex items-center gap-1.5 shadow-sm shadow-[#00ED64]/5">
            <span class="w-2 h-2 rounded-full bg-[#00ED64] animate-pulse"></span>
            <span class="text-xs font-mono font-bold text-[#00ED64]">
                <span id="stat-scanned">{{ $scannedTicketsCount }}</span>/<span id="stat-total">{{ $totalTicketsCount }}</span>
            </span>
        </div>
    </header>

    <!-- Main Scanner Area -->
    <main class="flex-1 flex flex-col items-center justify-center p-4 relative z-0">
        <!-- Viewport Container -->
        <div class="w-full max-w-[320px] aspect-square rounded-3xl bg-slate-900 border border-slate-800/80 overflow-hidden relative shadow-2xl flex flex-col items-center justify-center">
            
            <!-- Scanning lines / animation (hidden when camera active) -->
            <div id="scanner-laser" class="absolute left-0 w-full h-[2px] bg-[#00ED64] shadow-md shadow-[#00ED64]/50 z-10 animate-scan hidden"></div>

            <!-- Library Mount Point (Ignore Livewire changes) -->
            <div wire:ignore class="w-full h-full" id="reader-container">
                <div id="reader" class="w-full h-full border-none"></div>
            </div>

            <!-- Placeholder Screen -->
            <div id="scanner-placeholder" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center bg-slate-900">
                <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold mb-1">Camera Standby</h3>
                <p class="text-xs text-slate-400 max-w-[200px]">Activeer de camera om QR tickets te scannen aan de inkom.</p>
            </div>
        </div>

        <!-- Camera Controls -->
        <div class="mt-6 flex items-center gap-4">
            <button id="btn-toggle-camera" class="px-6 py-2.5 rounded-full bg-slate-800 hover:bg-slate-700 active:scale-95 border border-slate-700 text-xs font-bold transition-all flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500" id="camera-status-dot"></span>
                <span id="camera-status-text">Start Scanner</span>
            </button>
            <button id="btn-toggle-torch" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 active:scale-95 hover:bg-slate-700 transition-all hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </button>
        </div>
    </main>

    <!-- Scan History / List (Bottom sheet style) -->
    <footer class="bg-slate-900/65 backdrop-blur-md border-t border-slate-800/60 p-4 max-h-[220px] overflow-y-auto shrink-0 z-10">
        <h3 class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-3">Laatste Scans</h3>
        <div class="space-y-2" id="history-container">
            @forelse($history as $item)
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40 border border-slate-800/50 text-xs transition-all duration-300">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00ED64]"></div>
                        <div>
                            <p class="font-bold text-white">{{ $item['customer_name'] }}</p>
                            <p class="text-[10px] text-slate-400">{{ $item['ticket_type'] }} • {{ $item['code'] }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 font-bold bg-slate-800/80 px-2 py-0.5 rounded border border-slate-700/50">{{ $item['scanned_at'] }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-slate-500" id="history-empty">
                    Er zijn nog geen scans uitgevoerd tijdens deze sessie.
                </div>
            @endforelse
        </div>
    </footer>

    <!-- Immersion Full-Screen Feedback Overlay -->
    <div id="feedback-overlay" class="absolute inset-0 z-50 flex flex-col items-center justify-center p-6 text-center opacity-0 pointer-events-none transition-all duration-300 transform scale-110">
        <!-- Result Icon Container -->
        <div id="feedback-icon-container" class="w-24 h-24 rounded-full flex items-center justify-center text-white mb-6 shadow-2xl transform scale-75 transition-transform duration-500">
            <!-- Icon will be injected here by JS -->
        </div>
        <!-- Result Text -->
        <h2 id="feedback-title" class="text-4xl font-black uppercase tracking-tight mb-2"></h2>
        <p id="feedback-message" class="text-lg font-medium opacity-90 max-w-sm px-4 mb-4"></p>
        
        <!-- Ticket Type badge inside overlay -->
        <div id="feedback-badge" class="bg-black/20 text-white rounded-full px-4 py-1.5 text-sm font-bold border border-white/10 hidden"></div>
    </div>

    <!-- Scanner Logic Scripts -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Web Audio API generator
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            
            function playBeep(frequency, duration, type = 'sine') {
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                
                osc.type = type;
                osc.frequency.value = frequency;
                
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + duration);
                
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + duration);
            }

            // Scanner variables
            const eventId = "{{ $event->id }}";
            let html5QrCode = null;
            let cameraActive = false;
            let currentCameraId = null;
            let torchSupported = false;
            let torchActive = false;
            let scanActive = true; // Prevents double scanning while showing feedback

            // DOM elements
            const btnToggleCamera = document.getElementById('btn-toggle-camera');
            const btnToggleTorch = document.getElementById('btn-toggle-torch');
            const cameraStatusDot = document.getElementById('camera-status-dot');
            const cameraStatusText = document.getElementById('camera-status-text');
            const scannerPlaceholder = document.getElementById('scanner-placeholder');
            const scannerLaser = document.getElementById('scanner-laser');
            
            const feedbackOverlay = document.getElementById('feedback-overlay');
            const feedbackIconContainer = document.getElementById('feedback-icon-container');
            const feedbackTitle = document.getElementById('feedback-title');
            const feedbackMessage = document.getElementById('feedback-message');
            const feedbackBadge = document.getElementById('feedback-badge');

            // Success Icon SVG
            const successIcon = `<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>`;
            // Warning Icon SVG
            const warningIcon = `<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
            // Error Icon SVG
            const errorIcon = `<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>`;

            // Toggle camera action
            btnToggleCamera.addEventListener('click', function () {
                if (cameraActive) {
                    stopScanner();
                } else {
                    startScanner();
                }
            });

            // Toggle torch action
            btnToggleTorch.addEventListener('click', function () {
                if (!html5QrCode || !torchSupported) return;
                torchActive = !torchActive;
                html5QrCode.applyVideoConstraints({
                    advanced: [{ torch: torchActive }]
                }).then(() => {
                    btnToggleTorch.className = `w-10 h-10 rounded-full border flex items-center justify-center transition-all active:scale-95 ${torchActive ? 'bg-[#00ED64] border-[#00ED64] text-black shadow-md shadow-[#00ED64]/30' : 'bg-slate-800 border-slate-700 text-slate-400'}`;
                }).catch(err => {
                    console.error("Fout bij toepassen zaklamp:", err);
                });
            });

            function startScanner() {
                // Initialize AudioContext if suspended
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }

                scannerPlaceholder.classList.add('hidden');
                scannerLaser.classList.remove('hidden');
                
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        // Select back camera if available, otherwise first camera
                        let backCamera = devices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('rear') || device.label.toLowerCase().includes('omgeving'));
                        let selectedCameraId = backCamera ? backCamera.id : devices[0].id;
                        
                        html5QrCode = new Html5Qrcode("reader");
                        
                        html5QrCode.start(
                            selectedCameraId, 
                            {
                                fps: 15,
                                qrbox: { width: 220, height: 220 },
                                aspectRatio: 1.0
                            },
                            onScanSuccess,
                            onScanFailure
                        ).then(() => {
                            cameraActive = true;
                            cameraStatusDot.className = 'w-2.5 h-2.5 rounded-full bg-[#00ED64] animate-pulse';
                            cameraStatusText.innerText = 'Stop Scanner';
                            
                            // Check torch capability
                            const capabilities = html5QrCode.getRunningTrackCapabilities();
                            if (capabilities.torch) {
                                torchSupported = true;
                                btnToggleTorch.classList.remove('hidden');
                            }
                        }).catch(err => {
                            console.error("Camera start gefaald:", err);
                            alert("Kon camera niet starten: " + err);
                            stopScanner();
                        });
                    } else {
                        alert("Geen camera's gevonden op dit apparaat.");
                        stopScanner();
                    }
                }).catch(err => {
                    console.error("Lijst van camera's opvragen gefaald:", err);
                    alert("Fout bij opvragen camera's: " + err);
                    stopScanner();
                });
            }

            function stopScanner() {
                scannerPlaceholder.classList.remove('hidden');
                scannerLaser.classList.add('hidden');
                
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        html5QrCode = null;
                        resetCameraUI();
                    }).catch(err => {
                        console.error("Camera stop gefaald:", err);
                        html5QrCode = null;
                        resetCameraUI();
                    });
                } else {
                    resetCameraUI();
                }
            }

            function resetCameraUI() {
                cameraActive = false;
                torchSupported = false;
                torchActive = false;
                btnToggleTorch.className = 'w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 active:scale-95 hover:bg-slate-700 transition-all hidden';
                cameraStatusDot.className = 'w-2.5 h-2.5 rounded-full bg-red-500';
                cameraStatusText.innerText = 'Start Scanner';
            }

            function onScanSuccess(decodedText, decodedResult) {
                if (!scanActive) return; // Prevent scans during feedback overlay
                
                // We hebben een QR gescand! We verwachten een URL van onze tickets.scan route
                // Controleer of de URL naar onze applicatie wijst
                if (!decodedText.includes('/tickets/scan/')) {
                    showFeedback('error', 'ONGELDIG TICKET', 'Dit is geen geldig GrapATix ticket (verkeerd formaat).');
                    return;
                }

                scanActive = false; // Pauzeer verdere scans
                
                // Voer het AJAX request uit naar de signed URL
                fetch(decodedText, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Scanner-Event-Id': eventId
                    }
                })
                .then(response => {
                    if (response.status === 403) {
                        // Signed check failed (vervalst of aangepast)
                        return {
                            status: 'error',
                            message: 'Verbinding geweigerd: De cryptografische handtekening van dit ticket is ongeldig of vervalst!'
                        };
                    }
                    if (response.status === 404) {
                        return {
                            status: 'error',
                            message: 'Dit ticket is niet gevonden in ons platform database.'
                        };
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        showFeedback('success', 'GELDIG TICKET', data.message, data.ticket_type);
                        addHistoryItem(data.customer_name, data.ticket_type, decodedText, data.scanned_at);
                    } else if (data.status === 'already_scanned') {
                        showFeedback('warning', 'AL GEBRUIKT', data.message, data.ticket_type);
                    } else {
                        showFeedback('error', 'FOUT TICKET', data.message);
                    }
                })
                .catch(err => {
                    console.error("Scan fetch fout:", err);
                    showFeedback('error', 'SCAN FOUT', 'Er kon geen verbinding gemaakt worden met de server.');
                });
            }

            function onScanFailure(error) {
                // html5-qrcode roept dit aan bij elk frame waar geen QR-code gevonden wordt
                // We negeren dit om de log schoon te houden.
            }

            function showFeedback(type, title, message, badgeText = null) {
                // Configure overlay content
                feedbackTitle.innerText = title;
                feedbackMessage.innerText = message;
                
                if (badgeText) {
                    feedbackBadge.innerText = badgeText;
                    feedbackBadge.classList.remove('hidden');
                } else {
                    feedbackBadge.classList.add('hidden');
                }

                // Apply colors and play synth sound
                if (type === 'success') {
                    feedbackOverlay.className = 'absolute inset-0 z-50 flex flex-col items-center justify-center p-6 text-center transition-all duration-300 bg-emerald-950/98 text-emerald-100 opacity-100 scale-100';
                    feedbackIconContainer.className = 'w-24 h-24 rounded-full bg-emerald-500 flex items-center justify-center text-white mb-6 shadow-2xl shadow-emerald-500/30 transform scale-100 transition-transform duration-500';
                    feedbackIconContainer.innerHTML = successIcon;
                    playBeep(880, 0.15, 'sine'); // High bright beep
                } else if (type === 'warning') {
                    feedbackOverlay.className = 'absolute inset-0 z-50 flex flex-col items-center justify-center p-6 text-center transition-all duration-300 bg-amber-950/98 text-amber-100 opacity-100 scale-100';
                    feedbackIconContainer.className = 'w-24 h-24 rounded-full bg-amber-500 flex items-center justify-center text-white mb-6 shadow-2xl shadow-amber-500/30 transform scale-100 transition-transform duration-500';
                    feedbackIconContainer.innerHTML = warningIcon;
                    playBeep(180, 0.45, 'triangle'); // Low warning beep/buzz
                } else {
                    feedbackOverlay.className = 'absolute inset-0 z-50 flex flex-col items-center justify-center p-6 text-center transition-all duration-300 bg-rose-950/98 text-rose-100 opacity-100 scale-100';
                    feedbackIconContainer.className = 'w-24 h-24 rounded-full bg-rose-500 flex items-center justify-center text-white mb-6 shadow-2xl shadow-rose-500/30 transform scale-100 transition-transform duration-500';
                    feedbackIconContainer.innerHTML = errorIcon;
                    playBeep(120, 0.5, 'sawtooth'); // Deep angry buzz
                }

                // Auto-clear overlay after 2.5 seconds
                setTimeout(() => {
                    feedbackOverlay.classList.remove('opacity-100', 'scale-100');
                    feedbackOverlay.classList.add('opacity-0', 'scale-110');
                    feedbackIconContainer.classList.remove('scale-100');
                    feedbackIconContainer.classList.add('scale-75');
                    
                    // Resume scanner
                    setTimeout(() => {
                        scanActive = true;
                    }, 300);

                    // Refresh Livewire statistics on the background
                    @this.refreshStats().then(result => {
                        document.getElementById('stat-scanned').innerText = result.scanned;
                        document.getElementById('stat-total').innerText = result.total;
                    });
                }, 2500);
            }

            function addHistoryItem(name, type, url, scannedAtIso) {
                // Format scannedAt
                const d = new Date(scannedAtIso);
                const timeStr = String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0') + ':' + String(d.getSeconds()).padStart(2, '0');
                const ticketCode = 'GTX-' + url.split('/tickets/scan/')[1].split('?')[0].substring(0, 8).toUpperCase();
                
                const historyContainer = document.getElementById('history-container');
                const historyEmpty = document.getElementById('history-empty');
                
                if (historyEmpty) {
                    historyEmpty.remove();
                }

                // Create new history div
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between p-2 rounded-xl bg-slate-800/40 border border-slate-800/50 text-xs transition-all duration-300 opacity-0 transform translate-y-2';
                div.innerHTML = `
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00ED64]"></div>
                        <div>
                            <p class="font-bold text-white">${name}</p>
                            <p class="text-[10px] text-slate-400">${type} • ${ticketCode}</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 font-bold bg-slate-800/80 px-2 py-0.5 rounded border border-slate-700/50">${timeStr}</span>
                `;

                // Prepend to history container
                historyContainer.insertBefore(div, historyContainer.firstChild);
                
                // Animate in
                setTimeout(() => {
                    div.classList.remove('opacity-0', 'translate-y-2');
                }, 50);

                // Limit history items to 5
                if (historyContainer.children.length > 5) {
                    historyContainer.removeChild(historyContainer.lastChild);
                }
            }
        });
    </script>
    
    <style>
        @keyframes scan {
            0% { top: 5%; }
            50% { top: 95%; }
            100% { top: 5%; }
        }
        .animate-scan {
            animation: scan 2s linear infinite;
        }
        /* html5-qrcode clean override stylesheet */
        #reader__video {
            object-fit: cover !important;
            width: 100% !important;
            height: 100% !important;
            border-radius: 20px !important;
        }
        #reader__dashboard {
            display: none !important;
        }
    </style>
</div>

// Real-time notification system for NusaTripNow
class NotificationManager {
    constructor() {
        this.lastNotificationCheck = Date.now();
        this.interval = null;
        this.checkInterval = 30000; // Check every 30 seconds
    }

    init() {
        this.startPolling();
        console.log('Notification system initialized');
    }

    startPolling() {
        // Check immediately
        this.checkForNotifications();

        // Then check periodically
        this.interval = setInterval(() => {
            this.checkForNotifications();
        }, this.checkInterval);
    }

    stopPolling() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }

    async checkForNotifications() {
        try {
            const response = await fetch('/api/notifications/check', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.notifications && data.notifications.length > 0) {
                data.notifications.forEach(notification => {
                    if (new Date(notification.created_at).getTime() > this.lastNotificationCheck) {
                        this.showNotification(notification);
                    }
                });
                this.lastNotificationCheck = Date.now();
            }
        } catch (error) {
            console.log('Notification check failed:', error);
        }
    }

    showNotification(notification) {
        let title = 'Notifikasi';
        let icon = 'info';
        let confirmButtonColor = '#3085d6';

        if (notification.type === 'payment_approved') {
            title = 'Pembayaran Diterima!';
            icon = 'success';
            confirmButtonColor = '#28a745';
        } else if (notification.type === 'payment_uploaded') {
            title = 'Bukti Pembayaran Berhasil Diupload!';
            icon = 'success';
            confirmButtonColor = '#3085d6';
        }

        Swal.fire({
            title: title,
            text: notification.message,
            icon: icon,
            confirmButtonText: 'OK',
            confirmButtonColor: confirmButtonColor,
            timer: 10000, // Auto close after 10 seconds
            timerProgressBar: true,
            toast: false,
            position: 'center'
        });
    }

    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize for authenticated users
    if (document.querySelector('meta[name="csrf-token"]')) {
        const notificationManager = new NotificationManager();
        notificationManager.init();

        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            notificationManager.stopPolling();
        });
    }
});

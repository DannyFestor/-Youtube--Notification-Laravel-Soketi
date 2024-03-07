@props(['user', 'notifications'])

<div x-data="notification">
    <div @click="markRead" class="relative w-6 h-6">
        <x-bell />
        <x-count />
    </div>
    <x-notification-dropdown />
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notification', () => ({
            notifications: @json($notifications),

            get count() {
                return this.notifications.length;
            },

            async markRead() {
                const { data } = await axios.post('{{ route('notifications') }}');

                if (data !== undefined && data === 'ok') {
                    this.notifications = [];
                }
            },

            init() {
                Echo.private('notifications.{{ $user->id }}')
                    .listen('UserNotificationEvent', (e) => {
                        if (e.notification !== undefined) {
                            this.notifications.push(e.notification);
                        }
                    });
            },
        }));
    });
</script>
@endpush

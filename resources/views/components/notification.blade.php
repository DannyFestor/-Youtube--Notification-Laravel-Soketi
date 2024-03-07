@props(['user'])

<div x-data="notification">
    <div class="relative w-6 h-6">
        <x-bell />
        <x-count />
    </div>
    <x-notification-dropdown />
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notification', () => ({
            notifications: [],

            get count() {
                return this.notifications.length;
            },

            init() {
                Echo.private('notifications.{{ $user->id }}')
                    .listen('UserNotificationEvent', (e) => {
                        // Todo: Handle Event Data
                        console.log('private', e);
                    });
            },
        }));
    });
</script>
@endpush

<div
    x-data="toastNotification()"
    x-init="init()"
    class="fixed top-5 right-5 z-[9999] flex flex-col gap-3"
>
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="flex items-start gap-3 min-w-[320px] max-w-md p-4 rounded-xl shadow-lg border"
            :class="{
                'bg-green-50 border-green-200': toast.type === 'success',
                'bg-red-50 border-red-200': toast.type === 'error',
                'bg-yellow-50 border-yellow-200': toast.type === 'warning',
                'bg-blue-50 border-blue-200': toast.type === 'info'
            }"
        >
            <!-- Icon -->
            <div class="flex-shrink-0 mt-0.5">
                <!-- Success Icon -->
                <template x-if="toast.type === 'success'">
                    <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </template>
                <!-- Error Icon -->
                <template x-if="toast.type === 'error'">
                    <div class="w-6 h-6 rounded-full bg-red-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </template>
                <!-- Warning Icon -->
                <template x-if="toast.type === 'warning'">
                    <div class="w-6 h-6 rounded-full bg-yellow-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </template>
                <!-- Info Icon -->
                <template x-if="toast.type === 'info'">
                    <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1">
                <p class="font-semibold text-sm"
                   :class="{
                       'text-green-800': toast.type === 'success',
                       'text-red-800': toast.type === 'error',
                       'text-yellow-800': toast.type === 'warning',
                       'text-blue-800': toast.type === 'info'
                   }"
                   x-text="toast.title">
                </p>
                <p class="text-sm mt-0.5"
                   :class="{
                       'text-green-600': toast.type === 'success',
                       'text-red-600': toast.type === 'error',
                       'text-yellow-600': toast.type === 'warning',
                       'text-blue-600': toast.type === 'info'
                   }"
                   x-text="toast.message">
                </p>
            </div>

            <!-- Close Button -->
            <button
                @click="removeToast(toast.id)"
                class="flex-shrink-0 p-1 rounded-lg transition hover:bg-black/5"
                :class="{
                    'text-green-500': toast.type === 'success',
                    'text-red-500': toast.type === 'error',
                    'text-yellow-500': toast.type === 'warning',
                    'text-blue-500': toast.type === 'info'
                }"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastNotification() {
    return {
        toasts: [],
        counter: 0,

        init() {
            // Récupérer les messages de session Laravel
            @if(session('success'))
                this.addToast('success', 'Succès', '{{ session('success') }}');
            @endif

            @if(session('error'))
                this.addToast('error', 'Erreur', '{{ session('error') }}');
            @endif

            @if(session('warning'))
                this.addToast('warning', 'Attention', '{{ session('warning') }}');
            @endif

            @if(session('info'))
                this.addToast('info', 'Information', '{{ session('info') }}');
            @endif

            // Écouter les événements personnalisés pour les toasts dynamiques
            window.addEventListener('toast', (event) => {
                this.addToast(event.detail.type, event.detail.title, event.detail.message);
            });
        },

        addToast(type, title, message) {
            const id = ++this.counter;
            this.toasts.push({
                id,
                type,
                title,
                message,
                visible: true
            });

            // Auto-remove après 5 secondes
            setTimeout(() => {
                this.removeToast(id);
            }, 5000);
        },

        removeToast(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) {
                this.toasts[index].visible = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300);
            }
        }
    }
}
</script>

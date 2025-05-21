<!-- resources/vue/components/common/Notification.vue -->
<template>
    <transition name="fade">
      <div v-if="show" class="modal fade show" id="notificationModal" tabindex="-1" style="display: block;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ title }}</h5>
              <button type="button" class="btn-close" @click="closeNotification"></button>
            </div>
            <div class="modal-body">
              {{ message }}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="closeNotification">
                {{ buttonText }}
              </button>
            </div>
          </div>
        </div>
        <div class="modal-backdrop fade show"></div>
      </div>
    </transition>
  </template>

  <script>
  import { ref, watch, onMounted } from 'vue';

  export default {
    name: 'NotificationModal',
    props: {
      message: {
        type: String,
        default: ''
      },
      title: {
        type: String,
        default: 'Notifikasi'
      },
      buttonText: {
        type: String,
        default: 'Tutup'
      },
      duration: {
        type: Number,
        default: 0 // 0 means no auto-close
      },
      value: {
        type: Boolean,
        default: false
      }
    },
    emits: ['update:value'],
    setup(props, { emit }) {
      const show = ref(props.value);
      let timer = null;

      // Watch for changes in the value prop
      watch(() => props.value, (newValue) => {
        show.value = newValue;
        if (newValue && props.duration > 0) {
          startAutoCloseTimer();
        }
      });

      // Watch for changes in message prop
      watch(() => props.message, (newValue) => {
        if (newValue && !show.value) {
          show.value = true;
          if (props.duration > 0) {
            startAutoCloseTimer();
          }
        }
      });

      // Close notification
      const closeNotification = () => {
        show.value = false;
        emit('update:value', false);

        if (timer) {
          clearTimeout(timer);
          timer = null;
        }
      };

      // Start auto-close timer
      const startAutoCloseTimer = () => {
        if (timer) {
          clearTimeout(timer);
        }

        if (props.duration > 0) {
          timer = setTimeout(() => {
            closeNotification();
          }, props.duration);
        }
      };

      // On component mount
      onMounted(() => {
        if (show.value && props.duration > 0) {
          startAutoCloseTimer();
        }
      });

      return {
        show,
        closeNotification
      };
    }
  };
  </script>

  <style scoped>
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
    width: 100vw;
    height: 100vh;
  }

  /* Animations */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>

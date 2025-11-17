<script>
  // Seed initial wished IDs from server-provided data
  window.__WISHED_IDS__ = @json(($wishedIds ?? []));

  // Simple toast helper
  window.blToast = function(message, type = 'success') {
    const el = document.createElement('div');
    el.className = `fixed bottom-4 right-4 z-50 px-3 py-2 rounded-lg shadow-lg text-sm transition transform ${type === 'error' ? 'bg-red-600 text-white' : 'bg-ink text-white'} opacity-0`;
    el.textContent = message;
    document.body.appendChild(el);
    requestAnimationFrame(() => { el.style.opacity = '1'; el.style.transform = 'translateY(-4px)'; });
    setTimeout(() => {
      el.style.opacity = '0'; el.style.transform = 'translateY(0)';
      setTimeout(() => el.remove(), 250);
    }, 1800);
  }

  // Alpine store for wishlist
  document.addEventListener('alpine:init', () => {
    Alpine.store('wishlist', {
      ids: new Set((window.__WISHED_IDS__ || []).map(Number)),
      isFav(id) { return this.ids.has(Number(id)); },
      count() { return this.ids.size; },
      csrf() { const m = document.querySelector('meta[name=csrf-token]'); return m ? m.getAttribute('content') : ''; },
      async toggle(id) {
        id = Number(id);
        const url = `{{ url('/wishlist/toggle') }}/${id}`;
        try {
          const res = await fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': this.csrf(), 'Accept': 'application/json' }
          });
          if (res.status === 401) {
            // Not authenticated: redirect to login
            window.location.href = `{{ route('login') }}`;
            return false;
          }
          const data = await res.json();
          if (res.ok && data.success) {
            if (data.wished) { this.ids.add(id); } else { this.ids.delete(id); }
            document.dispatchEvent(new CustomEvent('wishlist:updated', { detail: { count: this.count() } }));
            blToast(data.wished ? 'Added to wishlist' : 'Removed from wishlist');
            return true;
          }
          blToast(data.message || 'Action failed', 'error');
          return false;
        } catch (e) {
          blToast('Network error. Please try again.', 'error');
          return false;
        }
      },
      async remove(id) { if (this.isFav(id)) { return this.toggle(id); } return false; },
      async clear() {
        try {
          const res = await fetch(`{{ url('/wishlist/clear') }}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': this.csrf(), 'Accept': 'application/json' } });
          if (res.status === 401) { window.location.href = `{{ route('login') }}`; return false; }
          const data = await res.json();
          if (res.ok && data.success) {
            this.ids.clear();
            document.dispatchEvent(new CustomEvent('wishlist:updated', { detail: { count: 0 } }));
            blToast('Cleared wishlist');
            return true;
          }
          blToast('Could not clear wishlist', 'error');
          return false;
        } catch (e) { blToast('Network error. Please try again.', 'error'); return false; }
      }
    });

    // Keep count badge in sync if present
    document.addEventListener('wishlist:updated', (ev) => {
      const cnt = ev.detail?.count ?? 0;
      const el = document.getElementById('wishlist-count');
      if (el) el.textContent = `${cnt}`;
    });
  });
</script>
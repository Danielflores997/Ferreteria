(() => {
    const openButton = document.getElementById('asistente-abrir');
    const panel = document.getElementById('asistente-panel');
    const closeButton = document.getElementById('asistente-cerrar');
    const form = document.getElementById('asistente-formulario');
    const input = document.getElementById('asistente-pregunta');
    const messages = document.getElementById('asistente-mensajes');
    const historyKey = 'ferreteria.asistente.history.v1';
    const openKey = 'ferreteria.asistente.open.v1';

    if (!openButton || !panel || !closeButton || !form || !input || !messages) return;

    const readHistory = () => {
        try {
            const stored = JSON.parse(sessionStorage.getItem(historyKey) || '[]');
            if (!Array.isArray(stored)) return [];
            return stored.flatMap((entry) => {
                if (entry?.type === 'message'
                    && ['bot', 'user'].includes(entry.sender)
                    && typeof entry.text === 'string') {
                    return [{type: 'message', sender: entry.sender, text: entry.text}];
                }
                if (entry?.type === 'products' && Array.isArray(entry.products)) {
                    const products = entry.products.map(normalizeProduct).filter(Boolean);
                    return products.length ? [{type: 'products', products}] : [];
                }
                return [];
            });
        } catch (error) {
            console.warn('No se pudo restaurar el historial del asistente.', error);
            return [];
        }
    };

    const history = readHistory();

    const saveHistory = () => {
        try {
            sessionStorage.setItem(historyKey, JSON.stringify(history));
        } catch (error) {
            console.warn('No se pudo guardar el historial del asistente.', error);
        }
    };

    function safeUrl(value, sameOriginOnly = false) {
        try {
            const parsed = new URL(value, window.location.href);
            if (!['http:', 'https:'].includes(parsed.protocol)) return null;
            if (sameOriginOnly && parsed.origin !== window.location.origin) return null;
            return parsed.href;
        } catch {
            return null;
        }
    }

    function normalizeProduct(product) {
        if (!product || typeof product !== 'object' || typeof product.url !== 'string') return null;
        const url = safeUrl(product.url, true);
        if (!url || typeof product.name !== 'string') return null;

        return {
            name: product.name,
            price: Number(product.price) || 0,
            store: typeof product.store === 'string' ? product.store : '',
            url,
            image: typeof product.image === 'string' ? safeUrl(product.image) || '' : ''
        };
    }

    const renderMessage = (text, sender) => {
        const message = document.createElement('p');
        message.className = `asistente-mensaje ${sender === 'user' ? 'asistente-mensaje-usuario' : 'asistente-mensaje-bot'}`;
        message.textContent = text;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
    };

    const addMessage = (text, sender) => {
        const entry = {type: 'message', sender, text: String(text)};
        history.push(entry);
        renderMessage(entry.text, sender);
        saveHistory();
    };

    const formatPrice = (price) => new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        maximumFractionDigits: 0
    }).format(price);

    const renderProducts = (products) => {
        if (!products.length) return;

        const list = document.createElement('div');
        list.className = 'asistente-productos';
        products.forEach((product) => {
            const link = document.createElement('a');
            link.className = 'asistente-producto';
            link.href = product.url;

            const image = document.createElement('img');
            if (product.image) image.src = product.image;
            image.alt = '';
            image.loading = 'lazy';

            const details = document.createElement('span');
            details.className = 'asistente-producto-info';
            const name = document.createElement('strong');
            name.textContent = product.name;
            const price = document.createElement('span');
            price.textContent = formatPrice(product.price);
            const store = document.createElement('span');
            store.textContent = product.store;
            details.append(name, price, store);
            link.append(image, details);
            list.appendChild(link);
        });
        messages.appendChild(list);
        messages.scrollTop = messages.scrollHeight;
    };

    const addProducts = (products) => {
        if (!Array.isArray(products)) return;
        const normalized = products.map(normalizeProduct).filter(Boolean);
        if (!normalized.length) return;
        history.push({type: 'products', products: normalized});
        renderProducts(normalized);
        saveHistory();
    };

    const setOpen = (isOpen, persist = true) => {
        panel.hidden = !isOpen;
        openButton.setAttribute('aria-expanded', String(isOpen));
        if (persist) {
            try {
                sessionStorage.setItem(openKey, String(isOpen));
            } catch (error) {
                console.warn('No se pudo guardar el estado del asistente.', error);
            }
        }
        if (isOpen) input.focus();
    };

    openButton.addEventListener('click', () => setOpen(panel.hidden));
    closeButton.addEventListener('click', () => {
        setOpen(false);
        openButton.focus();
    });

    history.forEach((entry) => {
        if (entry.type === 'message') renderMessage(entry.text, entry.sender);
        if (entry.type === 'products') renderProducts(entry.products);
    });
    try {
        setOpen(sessionStorage.getItem(openKey) === 'true', false);
    } catch (error) {
        console.warn('No se pudo restaurar el estado del asistente.', error);
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const question = input.value.trim();
        if (!question) return;

        addMessage(question, 'user');
        input.value = '';
        input.disabled = true;
        form.querySelector('button[type="submit"]').disabled = true;
        const loadingMessage = document.createElement('p');
        loadingMessage.className = 'asistente-mensaje asistente-mensaje-bot';
        loadingMessage.textContent = 'Buscando opciones...';
        messages.appendChild(loadingMessage);
        messages.scrollTop = messages.scrollHeight;

        try {
            const response = await fetch(form.dataset.endpoint, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({message: question})
            });
            const result = await response.json();
            loadingMessage.remove();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'No se pudo completar la consulta.');
            }
            addMessage(result.message, 'bot');
            addProducts(result.products);
        } catch (error) {
            loadingMessage.remove();
            addMessage(error.message || 'No se pudo conectar con el asistente. Prueba de nuevo.', 'bot');
        } finally {
            input.disabled = false;
            form.querySelector('button[type="submit"]').disabled = false;
            input.focus();
        }
    });
})();

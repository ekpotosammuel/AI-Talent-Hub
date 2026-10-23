import './bootstrap';

/**
 * Collapsible navigation (marketing header and app sidebar).
 */
document.querySelectorAll('[data-nav-toggle]').forEach((button) => {
    const menu = document.getElementById(button.dataset.navToggle);

    if (!menu) {
        return;
    }

    button.addEventListener('click', () => {
        const isHidden = menu.classList.toggle('hidden');
        button.setAttribute('aria-expanded', String(!isHidden));
    });
});

/**
 * Tab groups. Each trigger names the panel it reveals.
 * <div data-tabs><button data-tab="panel-id">…</button><div id="panel-id" data-tab-panel>…</div></div>
 */
document.querySelectorAll('[data-tabs]').forEach((group) => {
    const triggers = [...group.querySelectorAll('[data-tab]')];
    const panels = [...group.querySelectorAll('[data-tab-panel]')];

    const activate = (id) => {
        triggers.forEach((trigger) => {
            const isActive = trigger.dataset.tab === id;
            trigger.classList.toggle('tab-active', isActive);
            trigger.setAttribute('aria-selected', String(isActive));
        });

        panels.forEach((panel) => {
            panel.hidden = panel.id !== id;
        });
    };

    triggers.forEach((trigger) => trigger.addEventListener('click', () => activate(trigger.dataset.tab)));

    if (triggers.length > 0) {
        activate(triggers.find((trigger) => trigger.dataset.tabDefault !== undefined)?.dataset.tab ?? triggers[0].dataset.tab);
    }
});

/**
 * Disclosure rows — the issue lists in the document reviews use these.
 */
document.querySelectorAll('[data-disclosure]').forEach((button) => {
    const panel = document.getElementById(button.dataset.disclosure);

    if (!panel) {
        return;
    }

    button.addEventListener('click', () => {
        panel.hidden = !panel.hidden;
        button.setAttribute('aria-expanded', String(!panel.hidden));
        button.querySelector('[data-disclosure-caret]')?.classList.toggle('rotate-180');
    });
});

/**
 * Pipeline cards can be dragged between stage columns. Nothing is saved — the
 * board is a mockup — so the card simply moves and the counts follow it.
 */
const board = document.querySelector('[data-board]');

if (board) {
    let dragged = null;

    const refreshCounts = () => {
        board.querySelectorAll('[data-stage]').forEach((column) => {
            const count = column.querySelectorAll('[data-card]').length;
            const badge = column.querySelector('[data-stage-count]');

            if (badge) {
                badge.textContent = String(count);
            }
        });
    };

    board.querySelectorAll('[data-card]').forEach((card) => {
        card.setAttribute('draggable', 'true');

        card.addEventListener('dragstart', () => {
            dragged = card;
            card.classList.add('opacity-40');
        });

        card.addEventListener('dragend', () => {
            card.classList.remove('opacity-40');
            dragged = null;
            refreshCounts();
        });
    });

    board.querySelectorAll('[data-stage-drop]').forEach((zone) => {
        zone.addEventListener('dragover', (event) => {
            event.preventDefault();
            zone.classList.add('ring-2', 'ring-brand-400');
        });

        zone.addEventListener('dragleave', () => zone.classList.remove('ring-2', 'ring-brand-400'));

        zone.addEventListener('drop', (event) => {
            event.preventDefault();
            zone.classList.remove('ring-2', 'ring-brand-400');

            if (dragged) {
                zone.appendChild(dragged);
                refreshCounts();
            }
        });
    });
}

/**
 * Mock interview timer. Counts up from the elapsed time already on the page.
 */
const timer = document.querySelector('[data-timer]');

if (timer) {
    const [startMinutes, startSeconds] = timer.textContent.trim().split(':').map(Number);
    let elapsed = startMinutes * 60 + startSeconds;
    let running = true;

    const render = () => {
        const minutes = String(Math.floor(elapsed / 60)).padStart(2, '0');
        const seconds = String(elapsed % 60).padStart(2, '0');
        timer.textContent = `${minutes}:${seconds}`;
    };

    setInterval(() => {
        if (running) {
            elapsed += 1;
            render();
        }
    }, 1000);

    document.querySelector('[data-timer-toggle]')?.addEventListener('click', (event) => {
        running = !running;
        event.currentTarget.dataset.running = String(running);
        event.currentTarget.querySelector('[data-timer-label]').textContent = running ? 'Pause' : 'Resume';
    });
}

/**
 * Screens in the mobile gallery can be filtered by which side they belong to.
 */
document.querySelectorAll('[data-screen-filter]').forEach((button) => {
    button.addEventListener('click', () => {
        const side = button.dataset.screenFilter;

        document.querySelectorAll('[data-screen-filter]').forEach((other) => {
            other.classList.toggle('btn-ink', other === button);
            other.classList.toggle('btn-secondary', other !== button);
        });

        document.querySelectorAll('[data-screen]').forEach((screen) => {
            screen.hidden = side !== 'all' && screen.dataset.screen !== side;
        });
    });
});

(function () {
  const root = document.getElementById('promotion-wizard');
  if (!root) return;

  const configEl = document.getElementById('promotion-config');
  const config = configEl ? JSON.parse(configEl.textContent || '{}') : {};

  const steps = [
    'Platforms',
    'Objective',
    'Creative',
    'Audience',
    'Budget',
    'Review',
    'Submitted',
  ];

  const state = {
    step: 0,
    platforms: ['facebook', 'instagram', 'youtube'],
    objective: 'leads',
    creative: ['carousel', 'reel'],
    copy: { ...config.copy },
    editing: false,
    previewTab: 'facebook',
    smart: true,
    radius: 25,
    buyerTypes: ['Home Buyers', 'Investors', 'NRI Buyers'],
    interests: ['Villas', 'Luxury Properties'],
    ageMax: 55,
    duration: '15',
    budget: 5000,
    pack: 'pro',
  };

  const el = {
    progress: root.querySelector('[data-promo-progress]'),
    stepLabel: root.querySelector('[data-promo-step-label]'),
    panels: root.querySelectorAll('[data-promo-step]'),
    continueBtn: root.querySelector('[data-promo-continue]'),
    backBtn: root.querySelector('[data-promo-back]'),
    footerBar: root.querySelector('[data-promo-footer]'),
    platformCount: root.querySelector('[data-platform-count]'),
    estReach: root.querySelector('[data-est-reach]'),
    estClicks: root.querySelector('[data-est-clicks]'),
    estLeads: root.querySelector('[data-est-leads]'),
    budgetInput: root.querySelector('[data-budget-input]'),
    previewHost: root.querySelector('[data-preview-host]'),
    previewTabs: root.querySelector('[data-preview-tabs]'),
    headlineView: root.querySelector('[data-headline-view]'),
    primaryView: root.querySelector('[data-primary-view]'),
    headlineInput: root.querySelector('[data-headline-input]'),
    primaryInput: root.querySelector('[data-primary-input]'),
    editToggle: root.querySelector('[data-edit-toggle]'),
    reviewRows: root.querySelector('[data-review-rows]'),
    totalLabel: root.querySelector('[data-total-label]'),
  };

  function estimates(budget) {
    const reachLow = Math.round((budget * 4) / 1000) * 1000;
    const reachHigh = Math.round((budget * 10) / 1000) * 1000;
    const fmtK = (n) => (n >= 1000 ? `${(n / 1000).toFixed(n % 1000 === 0 ? 0 : 1)}K` : `${n}`);
    return {
      reach: `${fmtK(reachLow)}–${fmtK(reachHigh)}`,
      clicks: `${fmtK(Math.round(budget * 0.12))}–${fmtK(Math.round(budget * 0.35))}`,
      leads: `${Math.max(5, Math.round(budget * 0.005))}–${Math.round(budget * 0.018)}`,
    };
  }

  function inr(n) {
    return `₹${Number(n).toLocaleString('en-IN')}`;
  }

  function syncEstimates() {
    const est = estimates(state.budget);
    if (el.estReach) el.estReach.textContent = est.reach;
    if (el.estClicks) el.estClicks.textContent = est.clicks;
    if (el.estLeads) el.estLeads.textContent = est.leads;
    if (el.totalLabel) el.totalLabel.textContent = inr(state.budget);
    updateReview();
    syncPreviews();
  }

  function renderStep() {
    const idx = state.step;
    el.panels.forEach((panel) => {
      panel.classList.toggle('is-active', Number(panel.dataset.promoStep) === idx);
    });
  if (el.progress) {
      el.progress.style.width = `${((idx + 1) / steps.length) * 100}%`;
    }
    if (el.stepLabel) {
      el.stepLabel.textContent = `Step ${Math.min(idx + 1, steps.length)} of ${steps.length} · ${steps[idx]}`;
    }
    if (el.footerBar) {
      el.footerBar.hidden = idx >= 6;
    }
    if (el.continueBtn) {
      el.continueBtn.disabled = idx === 0 && state.platforms.length === 0;
      el.continueBtn.innerHTML =
        idx === 5
          ? '<i class="fas fa-credit-card"></i> Proceed to Payment'
          : 'Continue <i class="fas fa-arrow-right"></i>';
    }
    renderStepPanels();
  }

  function renderStepPanels() {
    // platform cards
    root.querySelectorAll('[data-platform-id]').forEach((btn) => {
      const id = btn.dataset.platformId;
      btn.classList.toggle('is-on', state.platforms.includes(id));
    });
    if (el.platformCount) {
      el.platformCount.textContent = `${state.platforms.length} platform${state.platforms.length === 1 ? '' : 's'} selected`;
    }
    root.querySelectorAll('[data-objective-id]').forEach((btn) => {
      btn.classList.toggle('is-on', btn.dataset.objectiveId === state.objective);
    });
    root.querySelectorAll('[data-creative-id]').forEach((btn) => {
      const id = btn.dataset.creativeId;
      btn.classList.toggle('is-on', state.creative.includes(id));
    });
    root.querySelectorAll('[data-duration-id]').forEach((btn) => {
      btn.classList.toggle('is-on', btn.dataset.durationId === state.duration);
    });
    root.querySelectorAll('[data-package-id]').forEach((btn) => {
      btn.classList.toggle('is-on', btn.dataset.packageId === state.pack);
    });
    root.querySelectorAll('[data-cta-option]').forEach((btn) => {
      btn.classList.toggle('is-on', btn.dataset.ctaOption === state.copy.cta);
    });
    root.querySelectorAll('[data-smart-audience]').forEach((btn) => {
      const smart = btn.dataset.smartAudience === 'true';
      btn.classList.toggle('is-on', state.smart === smart);
    });
    const customPanel = root.querySelector('[data-custom-audience]');
    if (customPanel) customPanel.hidden = state.smart;
    const radiusLabel = root.querySelector('[data-radius-label]');
    if (radiusLabel) radiusLabel.textContent = `${config.property?.city || 'Hyderabad'} · ${state.radius} km radius`;
    const ageLabel = root.querySelector('[data-age-label]');
    if (ageLabel) ageLabel.textContent = `25 – ${state.ageMax} years`;
    root.querySelectorAll('[data-buyer-type]').forEach((btn) => {
      btn.classList.toggle('is-on', state.buyerTypes.includes(btn.dataset.buyerType));
    });
    root.querySelectorAll('[data-interest]').forEach((btn) => {
      btn.classList.toggle('is-on', state.interests.includes(btn.dataset.interest));
    });
    toggleCopyFields();
    syncEstimates();
    buildPreviewTabs();
  }

  function toggleCopyFields() {
    const showInputs = state.editing;
    if (el.headlineView) el.headlineView.hidden = showInputs;
    if (el.primaryView) el.primaryView.hidden = showInputs;
    if (el.headlineInput) el.headlineInput.hidden = !showInputs;
    if (el.primaryInput) el.primaryInput.hidden = !showInputs;
    if (el.editToggle) {
      el.editToggle.innerHTML = showInputs
        ? '<i class="fas fa-check"></i> Done'
        : '<i class="fas fa-pen"></i> Edit Ad Content';
    }
    if (el.headlineView) el.headlineView.textContent = state.copy.headline;
    if (el.primaryView) el.primaryView.textContent = state.copy.primaryText;
    if (el.headlineInput && document.activeElement !== el.headlineInput) {
      el.headlineInput.value = state.copy.headline;
    }
    if (el.primaryInput && document.activeElement !== el.primaryInput) {
      el.primaryInput.value = state.copy.primaryText;
    }
  }

  function buildPreviewTabs() {
    if (!el.previewTabs) return;
    const selected = state.platforms.length ? state.platforms : ['facebook'];
    const active =
      selected.includes(state.previewTab) ? state.previewTab : selected[0];
    state.previewTab = active;
    el.previewTabs.innerHTML = '';
    (config.platforms || [])
      .filter((p) => selected.includes(p.id))
      .forEach((p) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = p.name;
        btn.classList.toggle('is-on', p.id === active);
        btn.addEventListener('click', () => {
          state.previewTab = p.id;
          buildPreviewTabs();
          syncPreviews();
        });
        el.previewTabs.appendChild(btn);
      });
    syncPreviews();
  }

  function syncPreviews() {
    if (!el.previewHost) return;
    el.previewHost.querySelectorAll('[data-preview-id]').forEach((node) => {
      const on = node.dataset.previewId === state.previewTab;
      node.classList.toggle('is-on', on);
      if (on) {
        node.querySelectorAll('[data-copy-headline]').forEach((n) => {
          n.textContent = state.copy.headline;
        });
        node.querySelectorAll('[data-copy-primary]').forEach((n) => {
          n.textContent = state.copy.primaryText;
        });
        node.querySelectorAll('[data-copy-cta]').forEach((n) => {
          n.textContent = state.copy.cta;
        });
      }
    });
  }

  function updateReview() {
    if (!el.reviewRows) return;
    const platformNames = state.platforms
      .map((id) => (config.platforms || []).find((p) => p.id === id)?.name)
      .filter(Boolean)
      .join(' + ');
    const objectiveName =
      (config.objectives || []).find((o) => o.id === state.objective)?.name || '';
    const creativeNames = state.creative
      .map((id) => (config.creatives || []).find((c) => c.id === id)?.name)
      .filter(Boolean)
      .join(' + ');
    const duration =
      (config.durations || []).find((d) => d.id === state.duration)?.days || 15;
    const rows = {
      platforms: platformNames,
      objective: objectiveName,
      creative: creativeNames,
      audience: state.smart ? 'CMNHousing Smart Targeting' : 'Custom',
      duration: `${duration} Days`,
      budget: inr(state.budget),
      reach: estimates(state.budget).reach,
    };
    Object.entries(rows).forEach(([key, value]) => {
      const target = el.reviewRows.querySelector(`[data-review="${key}"]`);
      if (target) target.textContent = value;
    });
  }

  function toggleList(list, value) {
    return list.includes(value) ? list.filter((v) => v !== value) : [...list, value];
  }

  root.querySelectorAll('[data-platform-id]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.platforms = toggleList(state.platforms, btn.dataset.platformId);
      if (!state.platforms.length) state.platforms = [btn.dataset.platformId];
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-objective-id]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.objective = btn.dataset.objectiveId;
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-creative-id]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.creative = toggleList(state.creative, btn.dataset.creativeId);
      if (!state.creative.length) state.creative = [btn.dataset.creativeId];
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-duration-id]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.duration = btn.dataset.durationId;
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-package-id]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.pack = btn.dataset.packageId;
      const amount = Number(btn.dataset.packageAmount || state.budget);
      state.budget = amount;
      if (el.budgetInput) el.budgetInput.value = amount;
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-cta-option]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.copy.cta = btn.dataset.ctaOption;
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-smart-audience]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.smart = btn.dataset.smartAudience === 'true';
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-buyer-type]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.buyerTypes = toggleList(state.buyerTypes, btn.dataset.buyerType);
      renderStepPanels();
    });
  });

  root.querySelectorAll('[data-interest]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.interests = toggleList(state.interests, btn.dataset.interest);
      renderStepPanels();
    });
  });

  const radiusInput = root.querySelector('[data-radius-input]');
  if (radiusInput) {
    radiusInput.addEventListener('input', () => {
      state.radius = Number(radiusInput.value);
      renderStepPanels();
    });
  }

  const ageInput = root.querySelector('[data-age-input]');
  if (ageInput) {
    ageInput.addEventListener('input', () => {
      state.ageMax = Number(ageInput.value);
      renderStepPanels();
    });
  }

  if (el.budgetInput) {
    el.budgetInput.addEventListener('input', () => {
      state.budget = Number(el.budgetInput.value) || 0;
      syncEstimates();
    });
  }

  if (el.headlineInput) {
    el.headlineInput.addEventListener('input', () => {
      state.copy.headline = el.headlineInput.value;
      syncPreviews();
      updateReview();
    });
  }

  if (el.primaryInput) {
    el.primaryInput.addEventListener('input', () => {
      state.copy.primaryText = el.primaryInput.value;
      syncPreviews();
    });
  }

  if (el.editToggle) {
    el.editToggle.addEventListener('click', () => {
      state.editing = !state.editing;
      toggleCopyFields();
    });
  }

  if (el.backBtn) {
    el.backBtn.addEventListener('click', () => {
      if (state.step === 0) {
        window.location.href = config.backUrl || '/';
        return;
      }
      state.step -= 1;
      renderStep();
    });
  }

  if (el.continueBtn) {
    el.continueBtn.addEventListener('click', () => {
      if (state.step === 5) {
        const paid = root.querySelector('[data-paid-amount]');
        if (paid) paid.textContent = inr(state.budget);
        const id = root.querySelector('[data-campaign-id]');
        if (id) id.textContent = config.campaignId || 'CMN-SM-2026-000123';
      }
      if (state.step < steps.length - 1) {
        state.step += 1;
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  }

  renderStep();
})();

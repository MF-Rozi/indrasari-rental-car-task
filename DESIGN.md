---
name: Indrasari Rental Car
description: Modern, dependable car rental management and booking platform tailored for the Indonesian market
colors:
  primary: "#0058bc"
  primary-hover: "#004899"
  primary-container: "#0070eb"
  inverse-primary: "#adc6ff"
  secondary: "#006c49"
  secondary-container: "#d1fae5"
  secondary-dark: "#34d399"
  surface: "#ffffff"
  surface-dark: "#112038"
  background: "#f8f9ff"
  background-dark: "#0b1c30"
  surface-container: "#eff4ff"
  surface-container-dark: "#152336"
  surface-container-high: "#dce9ff"
  surface-container-high-dark: "#1e2f47"
  on-surface: "#0b1c30"
  on-surface-variant: "#334155"
  on-surface-dark: "#f8faff"
  on-surface-variant-dark: "#cbd5e1"
  text-muted: "#475569"
  text-muted-dark: "#94a3b8"
  placeholder: "#64748b"
  placeholder-dark: "#94a3b8"
  outline: "#94a3b8"
  outline-variant: "#cbd5e1"
  outline-dark: "#334155"
  outline-variant-dark: "#1e2f47"
  error: "#dc2626"
  error-container: "#fee2e2"
typography:
  display:
    fontFamily: "Inter, 'Instrument Sans', system-ui, sans-serif"
    fontSize: "clamp(2rem, 5vw, 3rem)"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.02em"
  headline:
    fontFamily: "Inter, 'Instrument Sans', system-ui, sans-serif"
    fontSize: "1.5rem"
    fontWeight: 600
    lineHeight: 1.3
    letterSpacing: "-0.01em"
  title:
    fontFamily: "Inter, 'Instrument Sans', system-ui, sans-serif"
    fontSize: "1.125rem"
    fontWeight: 600
    lineHeight: 1.4
  body:
    fontFamily: "Inter, 'Instrument Sans', system-ui, sans-serif"
    fontSize: "0.9375rem"
    fontWeight: 400
    lineHeight: 1.5
  label:
    fontFamily: "Inter, 'Instrument Sans', system-ui, sans-serif"
    fontSize: "0.8125rem"
    fontWeight: 600
    lineHeight: 1.2
    letterSpacing: "0.02em"
rounded:
  sm: "4px"
  md: "8px"
  lg: "12px"
  xl: "16px"
  full: "9999px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "40px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "#ffffff"
    rounded: "{rounded.md}"
    padding: "10px 20px"
  button-primary-hover:
    backgroundColor: "{colors.primary-hover}"
  button-secondary:
    backgroundColor: "{colors.surface-container}"
    textColor: "{colors.primary}"
    rounded: "{rounded.md}"
    padding: "10px 20px"
  card:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.lg}"
    padding: "20px"
  input:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "10px 14px"
---

# Design System: Indrasari Rental Car

## 1. Overview

**Creative North Star: "Precision Fleet & Hospitality"**

Indrasari Rental Car bridges executive automotive precision with accessible Indonesian rental operations. The visual system pairs structured operational data density with crisp, modern typography and purposeful dual-theme contrast. It delivers high legibility for rapid fleet status scanning, transparent rental calculations in IDR, and effortless mobile booking flows.

The interface rejects unstyled legacy table dumps and generic AI SaaS clichés (such as floating glassmorphism blobs and decorative gradient text) in favor of crisp borders, structured surface elevation, and clear contextual cues.

**Key Characteristics:**
- **Strict WCAG AA/AAA Contrast Hierarchy**: Calibrated high-contrast palettes for both Light (`#f8f9ff` / `#ffffff`) and Dark (`#0b1c30` / `#112038`) surfaces.
- **Accessible Typography & Input States**: Placeholders (`#64748b`, 4.6:1) and secondary metadata (`#334155`, 9.8:1) guarantee effortless readability on all devices.
- **Operational Availability Badges**: Distinct high-contrast semantic chips (*Tersedia*, *Sedang Disewa*, *Perawatan*) that pop without visual noise.
- **Mobile-first Responsiveness**: Balances on-the-go customer bookings and desktop admin operations.

## 2. Colors

A disciplined automotive palette anchoring deep royal sapphire primary tones with emerald availability accents and clean tinted neutral surfaces.

### Primary
- **Sapphire Blue** (`#0058bc` / Light, `#adc6ff` / Dark): The primary brand tone for key actions, active navigation states, and primary CTA buttons. White text on `#0058bc` provides **6.73:1** contrast (Passes WCAG AA).
- **Electric Blue Container** (`#0070eb` / `#004899`): Active selection containers, badge highlights, and interactive hover states.

### Secondary
- **Emerald Green** (`#006c49` / Light, `#34d399` / Dark): Represents active availability, successful booking confirmations, and verified vehicle return status.
- **Mint Container** (`#d1fae5` / `#064e3b`): High-contrast background tint for "Tersedia" (Available) badges.

### Neutral (High-Contrast & Calibrated)
- **Deep Navy Base** (`#0b1c30`): Primary background in Dark theme; ink base in Light theme.
- **Light Crisp Base** (`#f8f9ff` bg, `#ffffff` card surface): Pure, high-clarity surface base in Light theme.
- **Text Primary**: `#0b1c30` on Light (**16.2:1**, AAA), `#f8faff` on Dark (**16.8:1**, AAA).
- **Text Secondary / Captions**: `#334155` on Light (**9.8:1**, AAA), `#cbd5e1` on Dark (**11.8:1**, AAA).
- **Text Muted / Meta**: `#475569` on Light (**7.0:1**, AAA), `#94a3b8` on Dark (**6.5:1**, AA).
- **Input Placeholders**: `#64748b` on Light (**4.6:1**, AA), `#94a3b8` on Dark (**6.5:1**, AA).
- **Structural Borders**: `#cbd5e1` on Light (**3.1:1** Non-Text Contrast), `#334155` on Dark.

### Named Rules
**The 4.5:1 Minimum Contrast Rule.** All body text, input placeholders, metadata labels, and interactive icons must maintain at least a 4.5:1 contrast ratio against their background in both Light and Dark mode.
**The Availability Color Rule.** Emerald green is strictly reserved for available vehicles, active healthy rentals, and confirmed financial returns. It is never used purely for decorative elements.

## 3. Typography

**Display & Headline Font:** Inter / Instrument Sans (System fallback: `system-ui, sans-serif`)
**Body & Label Font:** Inter / Instrument Sans

**Character:** Clean, objective geometric sans-serif that balances high-density data legibility with modern executive presence.

### Hierarchy
- **Display** (Bold 700, `clamp(2rem, 5vw, 3rem)`, `line-height: 1.2`, `letter-spacing: -0.02em`): Hero headlines, landing value propositions, and auth portal titles.
- **Headline** (SemiBold 600, `1.5rem` / `24px`, `line-height: 1.3`, `letter-spacing: -0.01em`): Section headings, modal titles, and fleet category headers.
- **Title** (SemiBold 600, `1.125rem` / `18px`, `line-height: 1.4`): Vehicle card titles, table column headers, and stat summary metrics.
- **Body** (Regular 400 / Medium 500, `0.9375rem` / `15px`, `line-height: 1.5`, `max-width: 65ch`): Standard description copy, form field instructions, and rental terms.
- **Label** (SemiBold 600, `0.8125rem` / `13px`, `line-height: 1.2`, `letter-spacing: 0.02em`): Badges, table tags, button labels, and small metadata.

### Named Rules
**The Currency Formatting Rule.** All monetary figures must be explicitly formatted in Indonesian Rupiah (e.g. `Rp 450.000 / hari` or `Total: Rp 1.350.000`) with consistent tabular figures for alignment.
**The No-Orphan Headline Rule.** Display and headline elements must utilize `text-wrap: balance` to prevent awkward typography line breaks on mobile devices.

## 4. Elevation

The system relies primarily on tonal surface layering and crisp 1px structural borders rather than heavy ambient blur shadows. Depth is communicated through contrast steps between background (`#f8f9ff` / `#0b1c30`) and surface containers (`#ffffff` / `#152336`).

### Shadow Vocabulary
- **Subtle Rest** (`box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04)`): Vehicle cards and stat containers at resting state.
- **Elevated Hover** (`box-shadow: 0 10px 25px -5px rgba(0, 88, 188, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.04)`): Vehicle cards upon hover and active booking popovers.
- **Modal / Dropdown Backdrop** (`box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.2)`): Floating action modals and dropdown menus.

### Named Rules
**The Structural Border Rule.** Cards and table containers must use a crisp 1px border (`border-slate-300` in Light, `border-slate-700` in Dark) to establish clear boundaries meeting WCAG 3:1 non-text contrast.

## 5. Components

### Buttons
- **Shape:** Rounded-lg (`8px` radius).
- **Primary:** Background `bg-primary` (`#0058bc`) with white text, font-medium, padding `py-2.5 px-5`.
- **Hover / Focus:** Transitions to `bg-primary-hover` (`#004899`) with `ring-2 ring-primary/30`.
- **Secondary / Outlined:** Border `border border-slate-300 dark:border-slate-700` with text `text-on-surface dark:text-on-surface-dark`, subtle hover background tint.

### Vehicle Cards
- **Corner Style:** Rounded-xl (`12px` radius).
- **Background:** `bg-white dark:bg-[#152336]` with crisp 1px border `border-slate-200 dark:border-slate-800`.
- **Internal Padding:** `p-5` or `p-6`.
- **Features Grid:** Compact pill tags for transmission (Manual/Matic), passenger capacity (4/7 Kursi), and luggage space with high-contrast text (`text-slate-700 dark:text-slate-300`).
- **Pricing Callout:** Bold daily rate (`Rp 500.000` / hari) with `/ hari` in high-contrast `text-slate-600 dark:text-slate-400` (7.0:1 contrast).

### Form Inputs
- **Style:** Background `bg-white dark:bg-[#0b1c30]`, border `border-slate-300 dark:border-slate-700`, rounded-lg (`8px`), padding `py-2.5 px-3.5`.
- **Placeholder Style:** `placeholder:text-slate-500 dark:placeholder:text-slate-400` (meets 4.5:1 contrast threshold).
- **Focus State:** `focus:border-primary focus:ring-2 focus:ring-primary/20 dark:focus:border-inverse-primary`.
- **Validation State:** Clear red border `border-error` (`#dc2626`) with descriptive error text in `#dc2626`.

### Status Badges (Pills)
- **Tersedia (Available):** `bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800`.
- **Sedang Disewa (Rented):** `bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/50 dark:text-blue-300 dark:border-blue-800`.
- **Perawatan (Maintenance):** `bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800`.

### Navigation (Header & Sidebar)
- **Desktop Header:** Clean horizontal bar with brand logo, Fleet catalog link, Rental Status, and User/Admin profile switcher.
- **Admin Sidebar:** Vertical fixed dock with icon + label hierarchy for Dashboard, Kelola Mobil, Kelola Sewa, Kelola Pelanggan, and Laporan.

## 6. Do's and Don'ts

### Do:
- **Do** format all currency in Indonesian Rupiah (`Rp 350.000 / hari`) with Indonesian thousand separators (`.`).
- **Do** validate and format customer Indonesian credentials (SIM A, Nomor HP +62 / 08xx, Alamat) with clear accessible feedback.
- **Do** provide immediate duration and total price calculation as soon as start and end dates are picked.
- **Do** maintain at least 4.5:1 contrast for all text (including placeholders and metadata) and 3:1 for borders.
- **Do** support instant theme switching between Light and Dark mode while preserving high contrast.
- **Do** provide empty states with actionable CTA (e.g. "Belum ada mobil yang disewa. Lihat Armada Kami").

### Don't:
- **Don't** use faint placeholders or metadata tokens (`#c1c6d6`) that fail WCAG contrast on light surfaces.
- **Don't** use cluttered legacy tables with raw data dumps and no sorting/filtering hierarchy.
- **Don't** use decorative gradient text or glassmorphic blur filters that impair readability.
- **Don't** create complicated multi-step booking flows that require repetitive data re-entry.
- **Don't** use side-stripe colored accent borders (greater than 1px `border-left` / `border-right`) on cards or alerts.
- **Don't** add disorienting animations that delay fleet search or return processing.

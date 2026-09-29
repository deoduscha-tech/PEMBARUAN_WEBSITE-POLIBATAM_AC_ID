/**
 * Komponen dasar — field form (input, textarea, select).
 *
 * Semuanya memakai gaya dan struktur label-error yang sama, supaya form di
 * panel admin terlihat seragam.
 */
const BASE =
  'w-full rounded border border-[#c9d2de] px-3 py-2.5 text-[0.9rem] text-[#1f2937] outline-none transition-colors focus:border-[#1e6fd9] focus:ring-2 focus:ring-[#1e6fd9]/20 disabled:bg-[#f3f5f8]';

const LABEL = 'text-[0.75rem] font-bold tracking-[0.03em] text-[#3b4757] uppercase';

function Wrapper({ label, name, error, required, hint, children }) {
  return (
    <label className="flex flex-col gap-1.5" htmlFor={name}>
      {label && (
        <span className={LABEL}>
          {label}
          {required && <span className="ml-1 text-red-500">*</span>}
        </span>
      )}
      {children}
      {hint && !error && <span className="text-[0.75rem] text-[#8894a6]">{hint}</span>}
      {error && <span className="text-[0.78rem] text-red-600">{error}</span>}
    </label>
  );
}

export function Input({ label, name, error, required, hint, className = '', ...rest }) {
  return (
    <Wrapper label={label} name={name} error={error} required={required} hint={hint}>
      <input
        id={name}
        name={name}
        className={`${BASE} ${error ? 'border-red-400' : ''} ${className}`}
        {...rest}
      />
    </Wrapper>
  );
}

export function Textarea({ label, name, error, required, hint, rows = 4, className = '', ...rest }) {
  return (
    <Wrapper label={label} name={name} error={error} required={required} hint={hint}>
      <textarea
        id={name}
        name={name}
        rows={rows}
        className={`${BASE} ${error ? 'border-red-400' : ''} ${className}`}
        {...rest}
      />
    </Wrapper>
  );
}

export function Select({ label, name, error, required, hint, options = [], className = '', ...rest }) {
  return (
    <Wrapper label={label} name={name} error={error} required={required} hint={hint}>
      <select
        id={name}
        name={name}
        className={`${BASE} ${error ? 'border-red-400' : ''} ${className}`}
        {...rest}
      >
        {options.map((option) => (
          <option key={option.value ?? option} value={option.value ?? option}>
            {option.label ?? option}
          </option>
        ))}
      </select>
    </Wrapper>
  );
}

/** Kotak centang dengan label di sebelah kanan. */
export function Checkbox({ label, name, className = '', ...rest }) {
  return (
    <label className="flex cursor-pointer items-center gap-2 text-[0.85rem] text-[#3b4757]">
      <input
        type="checkbox"
        id={name}
        name={name}
        className={`size-4 accent-[#1e6fd9] ${className}`}
        {...rest}
      />
      {label}
    </label>
  );
}
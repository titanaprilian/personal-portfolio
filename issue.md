# Bug: Featured Projects Display "Slot 1 / 2 / 3" Label Instead of "Featured"

**Labels:** `bug` `ui` `projects`
**Affected page:** `/projects` (public)

---

## Current Behavior (The Bug)

Featured projects on the public `/projects` page display the raw slot value as a label — e.g. **"Slot 1"**, **"Slot 2"**, **"Slot 3"**.

## Expected Behavior

The slot number is an internal ordering detail and should never be visible to visitors. Any featured project should display a **"Featured"** label regardless of which slot it occupies.

---

## Files Likely Involved

| File                                               | Why                                        |
| -------------------------------------------------- | ------------------------------------------ |
| `resources/views/projects/` (public projects view) | Where the slot label is currently rendered |

---

## Proposed Fix

In the public projects Blade view, replace the slot value display with a static **"Featured"** badge for any project where `featured_order` is not null.

---

## Test Scenarios

- A project assigned to any slot (1, 2, or 3) shows a **"Featured"** label — not "Slot 1", "Slot 2", or "Slot 3".
- A project with no featured slot shows no featured label.

---

## Acceptance Criteria

- [ ] The project list shows "Featured" (not the slot number) for all featured projects.
- [ ] Non-featured projects are unaffected.

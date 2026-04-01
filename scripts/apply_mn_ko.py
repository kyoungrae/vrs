#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Replace Mongolian (Cyrillic) UI strings with Korean using scripts/mn_ko_pairs.tsv.
Longest keys first to avoid partial replacements. Run from project root:
  python3 scripts/apply_mn_ko.py
"""
from __future__ import annotations

import pathlib
import sys

ROOT = pathlib.Path(__file__).resolve().parents[1]
TSV = ROOT / "scripts" / "mn_ko_pairs.tsv"

DIRS = [
    ROOT / "resources" / "views",
    ROOT / "app" / "Http" / "Controllers",
]

def is_target_file(p: pathlib.Path) -> bool:
    n = p.name.lower()
    return n.endswith(".blade.php") or n.endswith(".php")


def load_pairs() -> list[tuple[str, str]]:
    raw = TSV.read_text(encoding="utf-8")
    pairs: list[tuple[str, str]] = []
    for line in raw.splitlines():
        line = line.strip("\ufeff")
        if not line or line.startswith("#"):
            continue
        if "\t" not in line:
            continue
        a, b = line.split("\t", 1)
        a, b = a.strip(), b.strip()
        if a:
            pairs.append((a, b))
    pairs.sort(key=lambda x: len(x[0]), reverse=True)
    return pairs


def process_file(path: pathlib.Path, pairs: list[tuple[str, str]]) -> bool:
    try:
        text = path.read_text(encoding="utf-8")
    except OSError:
        return False
    orig = text
    for mn, ko in pairs:
        if mn in text:
            text = text.replace(mn, ko)
    if text != orig:
        path.write_text(text, encoding="utf-8")
        return True
    return False


def main() -> int:
    if not TSV.is_file():
        print("Missing", TSV, file=sys.stderr)
        return 1
    pairs = load_pairs()
    if not pairs:
        print("No pairs in", TSV, file=sys.stderr)
        return 1
    changed = 0
    files = 0
    for base in DIRS:
        if not base.is_dir():
            continue
        for p in base.rglob("*"):
            if not p.is_file():
                continue
            if not is_target_file(p):
                continue
            files += 1
            if process_file(p, pairs):
                changed += 1
                print("updated:", p.relative_to(ROOT))
    print(f"Done. Scanned {files} files, modified {changed}.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

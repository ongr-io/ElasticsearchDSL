CHANGELOG
=========

v1.x (201x)
---

- Fixed nested query in case `bool` with single `must` clause given (#32)
- Deprecated all filters and filtered query (#50)
- Added `filter` clause support for `BoolQuery` (#48)

v1.0.1 (2015-12-16)
---
               
- Fixed `function_score` query options handling (#35)
- Added Symfony 3 compatibility
- Added support for `timeout` and `terminate_after` options in Search endpoint (#34)

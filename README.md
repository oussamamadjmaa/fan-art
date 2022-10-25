# Change Log

## v1.0.1 - 25/10/2022

### Added
- Added **who's us** on home page
- Added **Show all artists** button under latest artists on **Home page**
- Added `artist_type` column to `users` table for diffrent type of artists *(Artist, Calligrapher)*
- Added **Artist type** input to artist registration form
- Added **Artist type** filter to **Artists page**
- Added `ArtistMessageMail` Mailable
- Added `queue jobs table`
- Added `Contact artists` page for `admin` role

### Changed
- Changed primary color from `#f26822` to `#034ea2`
- Changed default artist avatar image (changed color of hat from `red` to `blue`)
- Changed latest artists avatar size from **150px** to **100px** on **Home page**
- Changed latest artists limit (from **10** to **no limit**) `HomeController`
- Changed design of displaying artists (removed artworks) on **Artists page**
- Changed order of artists by who have the most `artworks_count` on **Artists page**

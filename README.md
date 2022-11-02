# Change Log

## [02/11/2022](https://github.com/oussamamadjmaa/fan-art/commit/b95b5c81a03dde9ebd509bf0513e6b08f283a143)

### Added
- VueJs
- Added API Controller and Resource for artists
- Added STORAGE_URL to GLOBAL js const


### Changed
- Changed home hero slider from blade to vuejs component
- Changed home joined us from blade to vuejs component 

## [29/10/2022](https://github.com/oussamamadjmaa/fan-art/commit/ce32eeb2aac5ec0e793ee3cff8855c4aff5292c0)

### Changed
- Removed `blogs` from navbar links and home page
- Disabled `blogs` routes
- Changed `contact us` navbar link

## [v1.0.1 - 25/10/2022](https://github.com/oussamamadjmaa/fan-art/commit/a632b163a8e68099defe7af0fbd595fb6ff78194)

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

# # Require any additional compass plugins here.
Encoding.default_external = "utf-8"

project_type = :stand_alone
# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "/"
sass_dir = "/"
images_dir = "/"

# output_style = :expanded
output_style = :compressed
environment    = :production

# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# disable comments in the output. We want admin comments
# to be verbose 
line_comments = false

asset_cache_buster :none
import sys
from PIL import Image

def make_square(img_path, out_path):
    img = Image.open(img_path)
    width, height = img.size
    
    # Calculate the side length of the square
    size = max(width, height)
    
    # Create a new transparent image with the square size
    new_img = Image.new("RGBA", (size, size), (255, 255, 255, 0))
    
    # Calculate position to paste the original image so it's centered
    x = (size - width) // 2
    y = (size - height) // 2
    
    new_img.paste(img, (x, y))
    
    # Optionally resize to 64x64 for standard favicon size
    new_img = new_img.resize((64, 64), Image.LANCZOS)
    
    new_img.save(out_path, "PNG")
    print(f"Saved padded image to {out_path}")

if __name__ == "__main__":
    make_square("public/assets/images/logo-mudain-icon.png", "public/assets/images/favicon.png")

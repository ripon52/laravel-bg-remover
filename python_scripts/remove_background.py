import sys
from PIL import Image
import rembg

def remove_background(input_path, output_path):
    try:
        # Open the image
        image = Image.open(input_path)

        # Convert the image to RGBA format (if not already)
        if image.mode != 'RGBA':
            image = image.convert('RGBA')

        # Use rembg library for background removal
        with rembg.open(input_path) as image_with_alpha:
            # Save the processed image with transparent background
            image_with_alpha.save(output_path, format='PNG')

        print("Image processed and saved successfully")
    except Exception as e:
        print(f"Error processing image: {e}")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python remove_background.py <input_image_path> <output_image_path>")
        sys.exit(1)

    input_image_path = sys.argv[1]
    output_image_path = sys.argv[2]

    remove_background(input_image_path, output_image_path)

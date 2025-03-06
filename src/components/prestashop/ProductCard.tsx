
import { cn } from "@/lib/utils";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";

interface ProductCardProps {
  name: string;
  price: string;
  image: string;
  description?: string;
  className?: string;
  badges?: string[];
  onAddToCart?: () => void;
}

const ProductCard = ({
  name,
  price,
  image,
  description,
  className,
  badges = [],
  onAddToCart,
}: ProductCardProps) => {
  return (
    <div
      className={cn(
        "group relative overflow-hidden rounded-lg border bg-background shadow-sm transition-all duration-300 hover:shadow-md animate-fade-in",
        className
      )}
    >
      <div className="relative aspect-square overflow-hidden bg-secondary/30">
        <img
          src={image}
          alt={name}
          className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
          loading="lazy"
        />
        
        {badges && badges.length > 0 && (
          <div className="absolute top-2 left-2 flex flex-wrap gap-1">
            {badges.map((badge, index) => (
              <Badge key={index} variant="secondary" className="animate-fade-in">
                {badge}
              </Badge>
            ))}
          </div>
        )}
      </div>
      
      <div className="p-4">
        <h3 className="font-medium line-clamp-1">{name}</h3>
        <div className="mt-1 flex items-end justify-between">
          <p className="text-lg font-semibold">{price}</p>
        </div>
        
        {description && (
          <p className="mt-2 text-sm text-muted-foreground line-clamp-2">
            {description}
          </p>
        )}
        
        {onAddToCart && (
          <Button
            onClick={onAddToCart}
            className="mt-3 w-full animate-hover"
            size="sm"
          >
            Add to cart
          </Button>
        )}
      </div>
    </div>
  );
};

export default ProductCard;

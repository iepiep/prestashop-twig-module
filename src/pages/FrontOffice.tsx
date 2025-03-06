
import { useState } from "react";
import { ChevronRight, Heart, Search, ShoppingCart } from "lucide-react";

import ModuleLayout from "@/components/prestashop/ModuleLayout";
import Header from "@/components/prestashop/Header";
import Card from "@/components/prestashop/Card";
import ProductCard from "@/components/prestashop/ProductCard";
import { toast } from "sonner";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";

// Sample product data
const products = [
  {
    id: 1,
    name: "Premium T-Shirt",
    price: "€29.99",
    image: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=500&auto=format&fit=crop",
    description: "100% cotton premium quality t-shirt with a modern fit.",
    badges: ["New", "Sale"],
  },
  {
    id: 2,
    name: "Casual Jeans",
    price: "€49.99",
    image: "https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=500&auto=format&fit=crop",
    description: "Comfortable casual jeans perfect for everyday wear.",
    badges: ["Bestseller"],
  },
  {
    id: 3,
    name: "Leather Shoes",
    price: "€89.99",
    image: "https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=500&auto=format&fit=crop",
    description: "Handcrafted genuine leather shoes with rubber sole.",
    badges: [],
  },
  {
    id: 4,
    name: "Woven Backpack",
    price: "€59.99",
    image: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=500&auto=format&fit=crop",
    description: "Stylish and practical woven backpack for everyday use.",
    badges: ["Sale"],
  },
];

const FrontOffice = () => {
  const [searchQuery, setSearchQuery] = useState("");

  const handleAddToCart = (productId: number, productName: string) => {
    toast.success(`Added ${productName} to your cart`, {
      description: "You can view your cart to complete your purchase",
      action: {
        label: "View Cart",
        onClick: () => console.log("View cart clicked"),
      },
    });
  };

  const filteredProducts = products.filter((product) =>
    product.name.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <ModuleLayout type="fo">
      <div className="flex justify-between items-center mb-8">
        <div className="flex-1">
          <Header
            type="fo"
            title="Our Products"
            subtitle="Explore our latest collection of premium products."
          />
        </div>
        
        <div className="flex items-center gap-3">
          <Button variant="ghost" size="icon" className="animate-hover">
            <Heart size={20} />
          </Button>
          <Button variant="ghost" size="icon" className="animate-hover">
            <ShoppingCart size={20} />
          </Button>
        </div>
      </div>

      <Card className="mb-8">
        <div className="flex flex-col md:flex-row items-center gap-4">
          <div className="relative flex-1 w-full">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground h-4 w-4" />
            <Input
              type="search"
              placeholder="Search products..."
              className="pl-9"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
            />
          </div>
          
          <div className="flex flex-wrap gap-2">
            <Badge variant="outline" className="animate-hover cursor-pointer">All</Badge>
            <Badge variant="outline" className="animate-hover cursor-pointer">New Arrivals</Badge>
            <Badge variant="outline" className="animate-hover cursor-pointer">Sale</Badge>
          </div>
        </div>
      </Card>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {filteredProducts.length > 0 ? (
          filteredProducts.map((product) => (
            <ProductCard
              key={product.id}
              name={product.name}
              price={product.price}
              image={product.image}
              description={product.description}
              badges={product.badges}
              onAddToCart={() => handleAddToCart(product.id, product.name)}
            />
          ))
        ) : (
          <div className="col-span-full py-12 text-center">
            <p className="text-muted-foreground">No products found matching "{searchQuery}"</p>
            <Button 
              variant="link" 
              onClick={() => setSearchQuery("")}
              className="mt-2"
            >
              Clear search
            </Button>
          </div>
        )}
      </div>

      <div className="mt-12 flex justify-center">
        <Button variant="outline" className="group">
          Load more products
          <ChevronRight className="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
        </Button>
      </div>
    </ModuleLayout>
  );
};

export default FrontOffice;

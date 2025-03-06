
import { useState } from "react";
import { motion } from "framer-motion";
import { Settings, ShoppingBag, ArrowRight } from "lucide-react";
import { Button } from "@/components/ui/button";
import BackOffice from "./BackOffice";
import FrontOffice from "./FrontOffice";

const Index = () => {
  const [view, setView] = useState<"home" | "bo" | "fo">("home");

  // Animation variants
  const containerVariants = {
    hidden: { opacity: 0 },
    visible: { 
      opacity: 1, 
      transition: { 
        when: "beforeChildren", 
        staggerChildren: 0.2 
      } 
    }
  };

  const itemVariants = {
    hidden: { opacity: 0, y: 20 },
    visible: { opacity: 1, y: 0 }
  };

  if (view === "bo") return <BackOffice />;
  if (view === "fo") return <FrontOffice />;

  return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gradient-to-b from-background to-secondary/50 p-6">
      <motion.div 
        className="max-w-3xl w-full text-center space-y-8"
        variants={containerVariants}
        initial="hidden"
        animate="visible"
      >
        <motion.div variants={itemVariants}>
          <h1 className="text-4xl sm:text-5xl font-bold tracking-tight mb-3">
            PrestaShop Module Demo
          </h1>
          <p className="text-xl text-muted-foreground max-w-2xl mx-auto">
            Explore this demo of a PrestaShop 8 module with Symfony and Twig functionality
          </p>
        </motion.div>

        <motion.div 
          className="grid md:grid-cols-2 gap-6 mt-12"
          variants={itemVariants}
        >
          <Button
            variant="outline"
            size="lg"
            className="h-40 glass flex flex-col items-center justify-center gap-3 group animate-hover"
            onClick={() => setView("bo")}
          >
            <Settings className="h-12 w-12 mb-2 text-primary" />
            <span className="text-xl font-medium">Back Office</span>
            <ArrowRight className="h-5 w-5 opacity-0 group-hover:opacity-100 transition-all absolute right-4 bottom-4" />
            <span className="text-sm text-muted-foreground">
              Configure the module
            </span>
          </Button>

          <Button
            variant="outline"
            size="lg"
            className="h-40 glass flex flex-col items-center justify-center gap-3 group animate-hover"
            onClick={() => setView("fo")}
          >
            <ShoppingBag className="h-12 w-12 mb-2 text-primary" />
            <span className="text-xl font-medium">Front Office</span>
            <ArrowRight className="h-5 w-5 opacity-0 group-hover:opacity-100 transition-all absolute right-4 bottom-4" />
            <span className="text-sm text-muted-foreground">
              View customer experience
            </span>
          </Button>
        </motion.div>

        <motion.div 
          className="mt-16 text-sm text-muted-foreground"
          variants={itemVariants}
        >
          <p>This is a demonstration of a PrestaShop 8 module with both Back Office and Front Office functionality.</p>
          <p className="mt-1">Select one of the options above to explore the module.</p>
        </motion.div>
      </motion.div>
    </div>
  );
};

export default Index;
